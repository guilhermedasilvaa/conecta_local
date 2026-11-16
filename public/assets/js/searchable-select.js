(() => {
    const normalize = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('pt-BR')
        .trim();

    const enhanceSelect = (select, index) => {
        if (select.dataset.searchableInitialized === 'true') return;
        select.dataset.searchableInitialized = 'true';

        const originalId = select.id;
        const inputId = `${originalId}-search`;
        const listId = `${originalId}-options`;
        const wrapper = document.createElement('div');
        wrapper.className = `searchable-select${select.dataset.searchCompact === 'true' ? ' searchable-select--compact' : ''}`;

        const input = document.createElement('input');
        input.className = 'searchable-select__input';
        input.id = inputId;
        input.type = 'text';
        input.autocomplete = 'off';
        input.placeholder = select.dataset.searchPlaceholder || 'Digite para buscar...';
        input.setAttribute('role', 'combobox');
        input.setAttribute('aria-autocomplete', 'list');
        input.setAttribute('aria-haspopup', 'listbox');
        input.setAttribute('aria-controls', listId);
        input.setAttribute('aria-expanded', 'false');

        const clearButton = document.createElement('button');
        clearButton.className = 'searchable-select__clear';
        clearButton.type = 'button';
        clearButton.textContent = '×';
        clearButton.setAttribute('aria-label', 'Limpar seleção');
        clearButton.hidden = true;

        const arrow = document.createElement('span');
        arrow.className = 'searchable-select__arrow';
        arrow.setAttribute('aria-hidden', 'true');
        arrow.textContent = '⌄';

        const list = document.createElement('div');
        list.className = 'searchable-select__list';
        list.id = listId;
        list.setAttribute('role', 'listbox');
        list.hidden = true;

        const parent = select.parentElement;
        if (!parent) return;

        parent.insertBefore(wrapper, select);
        wrapper.append(input, clearButton, arrow, list, select);
        select.hidden = true;
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');

        const label = [...document.querySelectorAll('label[for]')]
            .find((candidate) => candidate.htmlFor === originalId);
        if (label) label.htmlFor = inputId;

        let visibleOptions = [];
        let activeIndex = -1;
        let closeTimer = 0;
        let isSearching = false;
        let preserveQueryOnChange = false;

        const selectedOption = () => select.options[select.selectedIndex] || null;

        const syncFromSelect = () => {
            const option = selectedOption();
            input.value = option ? option.textContent.trim() : '';
            clearButton.hidden = !option || option.value === '';
            input.disabled = select.disabled;
            input.setAttribute('aria-disabled', String(select.disabled));
        };

        const close = (restoreSelection = false) => {
            list.hidden = true;
            input.setAttribute('aria-expanded', 'false');
            input.removeAttribute('aria-activedescendant');
            activeIndex = -1;
            if (restoreSelection) syncFromSelect();
        };

        const setActiveOption = (index) => {
            if (visibleOptions.length === 0) return;

            activeIndex = (index + visibleOptions.length) % visibleOptions.length;
            const options = list.querySelectorAll('[role="option"]');
            options.forEach((option, optionIndex) => {
                const active = optionIndex === activeIndex;
                option.classList.toggle('is-active', active);
                option.setAttribute('aria-selected', String(active));
            });

            const activeOption = options[activeIndex];
            input.setAttribute('aria-activedescendant', activeOption.id);
            activeOption.scrollIntoView({ block: 'nearest' });
        };

        const renderOptions = () => {
            const query = isSearching ? normalize(input.value) : '';
            visibleOptions = [...select.options]
                .filter((option) => option.value !== '')
                .filter((option) => normalize(option.textContent).includes(query));
            list.replaceChildren();
            activeIndex = -1;
            input.removeAttribute('aria-activedescendant');

            if (visibleOptions.length === 0) {
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'searchable-select__empty';
                emptyMessage.setAttribute('role', 'status');
                emptyMessage.textContent = 'Nenhuma opção encontrada.';
                list.append(emptyMessage);
                return;
            }

            visibleOptions.forEach((option, optionIndex) => {
                const item = document.createElement('div');
                item.className = 'searchable-select__option';
                item.id = `${listId}-option-${index}-${optionIndex}`;
                item.setAttribute('role', 'option');
                item.setAttribute('aria-selected', 'false');
                item.textContent = option.textContent.trim();
                item.addEventListener('mousedown', (event) => event.preventDefault());
                item.addEventListener('click', () => {
                    select.value = option.value;
                    syncFromSelect();
                    close();
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                });
                list.append(item);
            });
        };

        const open = () => {
            if (select.disabled) return;
            window.clearTimeout(closeTimer);
            renderOptions();
            list.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        };

        input.addEventListener('focus', () => {
            if (!isSearching) input.select();
            open();
        });
        input.addEventListener('click', open);
        input.addEventListener('input', () => {
            const query = input.value;
            isSearching = true;

            if (select.value !== '') {
                select.value = '';
                preserveQueryOnChange = true;
                select.dispatchEvent(new Event('change', { bubbles: true }));
                preserveQueryOnChange = false;
                input.value = query;
            }

            open();
            renderOptions();
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (list.hidden) open();
                setActiveOption(activeIndex < 0 ? 0 : activeIndex + 1);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (list.hidden) open();
                setActiveOption(activeIndex < 0 ? visibleOptions.length - 1 : activeIndex - 1);
            } else if (event.key === 'Enter' && !list.hidden && activeIndex >= 0) {
                event.preventDefault();
                list.querySelectorAll('[role="option"]')[activeIndex]?.click();
            } else if (event.key === 'Escape') {
                close(true);
            } else if (event.key === 'Tab') {
                close();
            }
        });

        input.addEventListener('blur', () => {
            closeTimer = window.setTimeout(() => close(true), 120);
        });

        clearButton.addEventListener('mousedown', (event) => event.preventDefault());
        clearButton.addEventListener('click', () => {
            select.value = '';
            isSearching = true;
            preserveQueryOnChange = true;
            input.value = '';
            select.dispatchEvent(new Event('change', { bubbles: true }));
            preserveQueryOnChange = false;
            input.value = '';
            clearButton.hidden = true;
            close();
            input.focus();
        });

        select.addEventListener('change', () => {
            const query = preserveQueryOnChange ? input.value : null;
            syncFromSelect();
            if (query !== null) {
                input.value = query;
            } else {
                isSearching = false;
            }
            if (!list.hidden) renderOptions();
        });

        const observer = new MutationObserver(() => {
            const selectedValue = select.value;
            syncFromSelect();
            if (!list.hidden) renderOptions();
            if (selectedValue && select.value !== selectedValue) input.value = '';
        });
        observer.observe(select, { childList: true, subtree: true, attributes: true, attributeFilter: ['disabled'] });

        syncFromSelect();
    };

    document.querySelectorAll('select[data-searchable-select]').forEach(enhanceSelect);
})();
