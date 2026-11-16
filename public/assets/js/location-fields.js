(() => {
    const cityCache = new Map();
    const neighborhoodCache = new Map();
    const ibgeBaseUrl = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/';
    const nominatimUrl = 'https://nominatim.openstreetmap.org/search';
    const overpassUrl = 'https://overpass-api.de/api/interpreter';

    const fetchWithTimeout = async (resource, options, timeoutMs) => {
        const controller = new AbortController();
        const timeout = window.setTimeout(() => controller.abort(), timeoutMs);

        try {
            return await fetch(resource, { ...options, signal: controller.signal });
        } finally {
            window.clearTimeout(timeout);
        }
    };

    document.querySelectorAll('[data-location-fields]').forEach((fields) => {
        const state = fields.querySelector('[data-location-state]');
        const city = fields.querySelector('[data-location-city]');
        const neighborhood = fields.querySelector('[data-location-neighborhood]');
        const cityStatus = fields.querySelector('[data-location-city-status]');
        const neighborhoodStatus = fields.querySelector('[data-location-neighborhood-status]');
        const cityRetry = fields.querySelector('[data-location-city-retry]');
        const neighborhoodList = fields.querySelector('[data-location-neighborhood-list]');

        if (!(state instanceof HTMLSelectElement)
            || !(city instanceof HTMLSelectElement)
            || !(neighborhood instanceof HTMLInputElement)
            || !(cityStatus instanceof HTMLElement)
            || !(neighborhoodStatus instanceof HTMLElement)
            || !(neighborhoodList instanceof HTMLDataListElement)) {
            return;
        }

        let cityRequest = 0;
        let neighborhoodRequest = 0;
        const initialCity = city.value;

        const setNeighborhoodStatus = (message) => {
            neighborhoodStatus.textContent = message;
        };

        const clearNeighborhoods = () => {
            neighborhoodList.replaceChildren();
        };

        const loadNeighborhoods = async (cityName, stateCode, stateName) => {
            const request = ++neighborhoodRequest;
            clearNeighborhoods();

            if (!cityName || !stateCode || !stateName) {
                setNeighborhoodStatus('Selecione uma cidade para ver sugestões de bairros.');
                return;
            }

            const cacheKey = `${stateCode}:${cityName}`;
            setNeighborhoodStatus('Buscando sugestões de bairros no OpenStreetMap...');

            try {
                let names = neighborhoodCache.get(cacheKey);

                if (!names) {
                    const searchUrl = new URL(nominatimUrl);
                    searchUrl.search = new URLSearchParams({
                        city: cityName,
                        state: stateName,
                        country: 'Brazil',
                        format: 'jsonv2',
                        limit: '1',
                        addressdetails: '0',
                    });

                    const searchResponse = await fetchWithTimeout(
                        searchUrl,
                        { headers: { Accept: 'application/json' } },
                        15000,
                    );
                    if (!searchResponse.ok) {
                        throw new Error(`OpenStreetMap search failed with status ${searchResponse.status}`);
                    }

                    const searchResults = await searchResponse.json();
                    const municipality = Array.isArray(searchResults) ? searchResults[0] : null;

                    if (
                        !municipality
                        || municipality.osm_type !== 'relation'
                        || !Number.isSafeInteger(Number(municipality.osm_id))
                        || Number(municipality.osm_id) < 1
                    ) {
                        throw new Error('OpenStreetMap did not return a municipality boundary');
                    }

                    const areaId = Number(municipality.osm_id) + 3600000000;
                    const query = `[out:json][timeout:25];area(${areaId})->.city;(node(area.city)["place"~"^(neighbourhood|suburb|quarter)$"];way(area.city)["place"~"^(neighbourhood|suburb|quarter)$"];relation(area.city)["place"~"^(neighbourhood|suburb|quarter)$"];);out tags center;`;
                    const response = await fetchWithTimeout(
                        overpassUrl,
                        {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
                            body: new URLSearchParams({ data: query }),
                        },
                        30000,
                    );

                    if (!response.ok) {
                        throw new Error(`OpenStreetMap data request failed with status ${response.status}`);
                    }

                    const result = await response.json();
                    if (!Array.isArray(result.elements)) {
                        throw new Error('OpenStreetMap returned an invalid neighborhood list');
                    }

                    names = [...new Set(result.elements
                        .map((element) => element.tags?.name)
                        .filter((name) => typeof name === 'string' && name.trim() !== '')
                        .map((name) => name.trim()))]
                        .sort((first, second) => first.localeCompare(second, 'pt-BR'));
                    neighborhoodCache.set(cacheKey, names);
                }

                if (request !== neighborhoodRequest) return;

                names.forEach((name) => {
                    const option = document.createElement('option');
                    option.value = name;
                    neighborhoodList.append(option);
                });

                setNeighborhoodStatus(names.length > 0
                    ? `${names.length} sugestão(ões) de bairro. A lista do OpenStreetMap pode estar incompleta; você também pode digitar.`
                    : 'O OpenStreetMap não tem bairros mapeados para esta cidade. Você pode digitar o bairro.');
            } catch (error) {
                if (request !== neighborhoodRequest) return;

                console.error('Não foi possível carregar sugestões de bairros do OpenStreetMap.', error);
                setNeighborhoodStatus('Não foi possível carregar sugestões de bairros agora. Você pode digitar o bairro.');
            }
        };

        const loadCities = async (stateCode, desiredCity = '') => {
            const request = ++cityRequest;
            ++neighborhoodRequest;
            city.replaceChildren(new Option(
                stateCode ? 'Carregando cidades...' : 'Selecione um estado primeiro',
                '',
            ));
            city.disabled = true;
            if (cityRetry) cityRetry.hidden = true;
            cityStatus.textContent = stateCode ? 'Carregando municípios do IBGE...' : 'Selecione um estado para escolher a cidade.';
            clearNeighborhoods();
            setNeighborhoodStatus('Selecione uma cidade para ver sugestões de bairros.');

            if (!stateCode) return;

            try {
                let municipalities = cityCache.get(stateCode);

                if (!municipalities) {
                    const response = await fetchWithTimeout(
                        `${ibgeBaseUrl}${encodeURIComponent(stateCode)}/municipios?orderBy=nome`,
                        { headers: { Accept: 'application/json' } },
                        15000,
                    );
                    if (!response.ok) {
                        throw new Error(`IBGE request failed with status ${response.status}`);
                    }

                    municipalities = await response.json();
                    if (!Array.isArray(municipalities)) {
                        throw new Error('IBGE returned an invalid municipality list');
                    }

                    municipalities = municipalities.filter((municipality) =>
                        municipality
                        && typeof municipality.nome === 'string'
                        && municipality.nome.trim() !== '');
                    cityCache.set(stateCode, municipalities);
                }

                if (request !== cityRequest) return;

                city.replaceChildren(new Option('Selecione sua cidade', ''));
                municipalities.forEach((municipality) => {
                    city.add(new Option(municipality.nome, municipality.nome));
                });

                let statusMessage = `${municipalities.length} municípios carregados pelo IBGE.`;
                if (desiredCity) {
                    const normalizedDesired = desiredCity.trim().toLocaleLowerCase('pt-BR');
                    const match = [...city.options].find((option) =>
                        option.value.trim().toLocaleLowerCase('pt-BR') === normalizedDesired);

                    if (match) {
                        match.selected = true;
                    } else {
                        city.add(new Option(`${desiredCity} (cidade salva anteriormente)`, desiredCity, true, true));
                        statusMessage = 'Municípios carregados pelo IBGE. A cidade já salva foi preservada, mas não consta na lista atual.';
                    }
                }

                city.disabled = false;
                cityStatus.textContent = statusMessage;

                if (city.value) {
                    const selectedState = state.options[state.selectedIndex];
                    loadNeighborhoods(city.value, stateCode, selectedState?.dataset.stateName || '');
                }
            } catch (error) {
                if (request !== cityRequest) return;

                console.error('Não foi possível carregar municípios do IBGE.', error);
                city.replaceChildren(new Option('Não foi possível carregar as cidades', ''));
                if (desiredCity) {
                    city.add(new Option(`${desiredCity} (cidade salva anteriormente)`, desiredCity, true, true));
                }
                city.disabled = false;
                if (cityRetry) cityRetry.hidden = false;
                cityStatus.textContent = 'Falha ao carregar cidades do IBGE. Tente novamente ou mantenha a cidade já salva.';
            }
        };

        state.addEventListener('change', () => {
            neighborhood.value = '';
            loadCities(state.value);
        });

        city.addEventListener('change', () => {
            neighborhood.value = '';
            const selectedState = state.options[state.selectedIndex];
            loadNeighborhoods(city.value, state.value, selectedState?.dataset.stateName || '');
        });

        cityRetry?.addEventListener('click', () => loadCities(state.value, city.value));

        fields.closest('form')?.addEventListener('submit', (event) => {
            if (city.required && (!state.value || !city.value)) {
                event.preventDefault();
                cityStatus.textContent = !state.value
                    ? 'Selecione um estado antes de escolher a cidade.'
                    : city.disabled
                        ? 'Aguarde o carregamento das cidades antes de continuar.'
                        : 'Selecione uma cidade da lista para continuar.';

                if (!city.disabled && state.value) city.focus();
                else state.focus();
            }
        });

        loadCities(state.value, initialCity);
    });
})();
