(() => {
    const storageKey = 'conecta-local-search-location-v1';
    const reverseGeocodeUrl = 'https://nominatim.openstreetmap.org/reverse';
    const stateNames = new Map([
        ['acre', 'AC'],
        ['alagoas', 'AL'],
        ['amapa', 'AP'],
        ['amazonas', 'AM'],
        ['bahia', 'BA'],
        ['ceara', 'CE'],
        ['distrito federal', 'DF'],
        ['espirito santo', 'ES'],
        ['goias', 'GO'],
        ['maranhao', 'MA'],
        ['mato grosso', 'MT'],
        ['mato grosso do sul', 'MS'],
        ['minas gerais', 'MG'],
        ['para', 'PA'],
        ['paraiba', 'PB'],
        ['parana', 'PR'],
        ['pernambuco', 'PE'],
        ['piaui', 'PI'],
        ['rio de janeiro', 'RJ'],
        ['rio grande do norte', 'RN'],
        ['rio grande do sul', 'RS'],
        ['rondonia', 'RO'],
        ['roraima', 'RR'],
        ['santa catarina', 'SC'],
        ['sao paulo', 'SP'],
        ['sergipe', 'SE'],
        ['tocantins', 'TO'],
    ]);

    const normalize = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('pt-BR')
        .trim();

    const readLocationCache = () => {
        try {
            const value = sessionStorage.getItem(storageKey);
            return value ? JSON.parse(value) : null;
        } catch {
            return null;
        }
    };

    const saveLocationCache = (value) => {
        try {
            sessionStorage.setItem(storageKey, JSON.stringify(value));
        } catch {
            // Location remains available for the current page if session storage is disabled.
        }
    };

    const reverseGeocode = async (latitude, longitude) => {
        const url = new URL(reverseGeocodeUrl);
        url.search = new URLSearchParams({
            lat: String(latitude),
            lon: String(longitude),
            format: 'jsonv2',
            zoom: '10',
            addressdetails: '1',
        });

        const controller = new AbortController();
        const timeout = window.setTimeout(() => controller.abort(), 12000);

        try {
            const response = await fetch(url, {
                headers: { Accept: 'application/json' },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`Reverse geocoding failed with status ${response.status}`);
            }

            const result = await response.json();
            const address = result.address;

            if (!address || address.country_code?.toLowerCase() !== 'br') {
                throw new Error('No Brazilian address was found for the current position');
            }

            const city = [
                address.city,
                address.town,
                address.village,
                address.municipality,
            ].find((value) => typeof value === 'string' && value.trim() !== '');
            const stateSubdivision = address['ISO3166-2-lvl4'];
            const state = typeof stateSubdivision === 'string' && /^BR-[A-Z]{2}$/.test(stateSubdivision)
                ? stateSubdivision.slice(3)
                : stateNames.get(normalize(address.state || ''));

            if (!city || !state) {
                throw new Error('The reverse geocoder did not identify a city and state');
            }

            return { city: city.trim(), state };
        } finally {
            window.clearTimeout(timeout);
        }
    };

    document.querySelectorAll('[data-geolocation-search]').forEach((form) => {
        const cityInput = form.querySelector('[data-geolocation-city]');
        const stateInput = form.querySelector('[data-geolocation-state]');
        const locationLabel = form.querySelector('[data-geolocation-location]');
        const status = form.querySelector('[data-geolocation-status]');
        const retryButton = form.querySelector('[data-geolocation-retry]');

        if (!(cityInput instanceof HTMLInputElement)
            || !(stateInput instanceof HTMLInputElement)
            || !(locationLabel instanceof HTMLElement)
            || !(status instanceof HTMLElement)
            || !(retryButton instanceof HTMLButtonElement)) {
            return;
        }

        let requestId = 0;

        const showLocation = ({ city, state }) => {
            cityInput.value = city;
            stateInput.value = state;
            locationLabel.textContent = `${city} - ${state}`;
            status.textContent = '';
            status.hidden = true;
            status.classList.add('hidden');
            retryButton.hidden = true;
        };

        const showFailure = (message) => {
            cityInput.value = '';
            stateInput.value = '';
            locationLabel.textContent = 'Localização indisponível';
            status.textContent = `${message} A busca continuará disponível, mas sem filtro por localização.`;
            status.hidden = false;
            status.classList.remove('hidden');
            retryButton.hidden = false;
        };

        const findLocation = async (force = false) => {
            const currentRequest = ++requestId;

            if (!force && cityInput.value.trim() !== '' && /^[A-Z]{2}$/.test(stateInput.value)) {
                showLocation({ city: cityInput.value.trim(), state: stateInput.value });
                return;
            }

            if (force) {
                cityInput.value = '';
                stateInput.value = '';
                locationLabel.textContent = 'Detectando localização...';
                status.textContent = 'Buscando sua localização...';
                retryButton.hidden = true;
            }

            const cachedLocation = readLocationCache();
            if (!force && cachedLocation?.city && /^[A-Z]{2}$/.test(cachedLocation.state || '')) {
                showLocation(cachedLocation);
                return;
            }

            if (!force && cachedLocation?.status === 'denied') {
                showFailure('Você não autorizou o acesso à localização.');
                return;
            }

            if (!window.isSecureContext) {
                showFailure('A localização automática requer uma conexão segura (HTTPS).');
                return;
            }

            if (!navigator.geolocation) {
                showFailure('Este navegador não oferece suporte à localização automática.');
                saveLocationCache({ status: 'unsupported' });
                return;
            }

            status.textContent = 'Buscando sua localização...';
            locationLabel.textContent = 'Detectando localização...';
            retryButton.hidden = true;

            try {
                navigator.geolocation.getCurrentPosition(async (position) => {
                    try {
                        const location = await reverseGeocode(
                            Math.round(position.coords.latitude * 1000) / 1000,
                            Math.round(position.coords.longitude * 1000) / 1000,
                        );

                        if (currentRequest !== requestId) return;

                        saveLocationCache(location);
                        showLocation(location);
                    } catch (error) {
                        if (currentRequest !== requestId) return;

                        console.error('Não foi possível converter as coordenadas em cidade e estado.');
                        showFailure('Não foi possível identificar sua cidade agora.');
                    }
                }, (error) => {
                    if (currentRequest !== requestId) return;

                    if (error.code === error.PERMISSION_DENIED) {
                        saveLocationCache({ status: 'denied' });
                        showFailure('Você negou a permissão de localização.');
                        return;
                    }

                    if (error.code === error.POSITION_UNAVAILABLE) {
                        showFailure('Sua localização não está disponível no momento.');
                        return;
                    }

                    showFailure('A localização demorou para responder.');
                }, {
                    enableHighAccuracy: false,
                    maximumAge: 300000,
                    timeout: 10000,
                });
            } catch (error) {
                if (currentRequest !== requestId) return;

                console.error('Não foi possível solicitar a localização do navegador.', error);
                showFailure('O navegador bloqueou o acesso à localização.');
            }
        };

        retryButton.addEventListener('click', () => {
            saveLocationCache({ status: 'retry' });
            findLocation(true);
        });

        findLocation();
    });
})();
