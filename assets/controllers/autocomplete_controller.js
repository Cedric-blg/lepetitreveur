import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["input"]

    connect() {
        // Container to display selected users as removable tags
        this.tagsContainer = document.createElement('div');
        this.tagsContainer.className = 'selected-users';
        this.inputTarget.after(this.tagsContainer);

        // Suggestions list
        this.list = document.createElement('ul');
        this.list.className = 'autocomplete-results';
        this.tagsContainer.after(this.list);

        // Config via data attributes (with sensible defaults)
        // data-autocomplete-search-url: endpoint to fetch suggestions
        // data-autocomplete-hidden-name: name for hidden input(s)
        // data-autocomplete-multiple: '1' for multiple, '0' for single
        this.searchUrl = this.inputTarget.dataset.autocompleteSearchUrl || '/user/user-search';
        this.hiddenName = this.inputTarget.dataset.autocompleteHiddenName || 'parents[]';
        this.isMultiple = (this.inputTarget.dataset.autocompleteMultiple || '1') !== '0';

        // Prefill if initial selection is provided (useful for edit forms)
        const initialId = this.inputTarget.dataset.autocompleteInitialId;
        const initialText = this.inputTarget.dataset.autocompleteInitialText;
        if (initialId && initialText) {
            this.#addSelectedItem({ id: initialId, text: initialText });
        }
    }

    async search() {
        if(this.inputTarget.value.length < 1) {
            this.list.innerHTML = '';
            return;
        }

        const response = await fetch(`${this.searchUrl}?q=${encodeURIComponent(this.inputTarget.value)}`);
        const users = await response.json();

        this.list.innerHTML = '';
        users.forEach(u => {
            const li = document.createElement('li');
            li.textContent = u.text;
            li.dataset.id = u.id;
            li.addEventListener('click', () => {
                this.#addSelectedItem(u);
                this.inputTarget.value = '';
                this.list.innerHTML = '';
            });
            this.list.appendChild(li);
        });
    }

    // Private helper to add tag + hidden input, avoids duplicates and wires remove action
    #addSelectedItem(user) {
        // Prevent duplicates
        const exists = this.element.querySelector(
            `input[type="hidden"][name="${CSS.escape(this.hiddenName)}"][value="${CSS.escape(String(user.id))}"]`
        );
        if (exists) {
            return;
        }

        // If single selection, clear previous tag + hidden
        if (!this.isMultiple) {
            this.tagsContainer.querySelectorAll('.selected-user-tag').forEach(el => el.remove());
            this.element.querySelectorAll(`input[type=hidden][name="${this.hiddenName}"]`).forEach(el => el.remove());
        }

        // Create hidden input inside the form
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = this.hiddenName;
        hidden.value = user.id;

        // Create visual tag
        const tag = document.createElement('span');
        tag.className = 'selected-user-tag';
        tag.textContent = user.text + ' ';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-user-tag';
        removeBtn.setAttribute('aria-label', 'Retirer');
        removeBtn.textContent = '×';
        removeBtn.addEventListener('click', () => {
            hidden.remove();
            tag.remove();
        });

        tag.appendChild(removeBtn);

        // Insert into DOM (container is within the form)
        this.tagsContainer.appendChild(tag);
        this.tagsContainer.appendChild(hidden);
    }
}