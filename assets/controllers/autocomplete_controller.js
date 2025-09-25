import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["input"]

    connect() {
        this.list = document.createElement('ul');
        this.inputTarget.after(this.list);
    }

    async search() {
        if(this.inputTarget.value.length < 1) {
            this.list.innerHTML = '';
            return;
        }

        const response = await fetch(`/user/user-search?q=${encodeURIComponent(this.inputTarget.value)}`);
        const users = await response.json();

        this.list.innerHTML = '';
        users.forEach(u => {
            const li = document.createElement('li');
            li.textContent = u.text;
            li.dataset.id = u.id;
            li.addEventListener('click', () => {
                const inputHidden = document.createElement('input');
                inputHidden.type = 'hidden';
                inputHidden.name = 'parents[]';
                inputHidden.value = u.id;
                this.inputTarget.after(inputHidden);
                this.list.innerHTML = '';
            });
            this.list.appendChild(li);
        });
    }
}