

import Alpine from 'alpinejs';
import 'bootstrap';

window.Alpine = Alpine;

Alpine.start();

const startLiveNotifications = () => {
	const liveNotifications = document.querySelector('.toast-container[data-live-notifications]');

	if (!liveNotifications) {
		return;
	}

	const feedUrl = liveNotifications.dataset.feedUrl;
	const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
	const seenNotifications = new Set();

	const showNotification = (notification) => {
		if (seenNotifications.has(notification.id)) {
			return;
		}

		seenNotifications.add(notification.id);

		const toast = document.createElement('div');
		toast.className = 'toast show halo-live-toast border-0 shadow-lg';
		toast.setAttribute('role', 'alert');
		toast.setAttribute('aria-live', 'assertive');

		const header = document.createElement('div');
		header.className = 'toast-header';
		header.innerHTML = '<span class="halo-toast-icon me-2">!</span>';
		const title = document.createElement('strong');
		title.className = 'me-auto';
		title.textContent = 'HALO IT update';
		const time = document.createElement('small');
		time.textContent = notification.created_at;
		const close = document.createElement('button');
		close.className = 'btn-close';
		close.type = 'button';
		close.setAttribute('aria-label', 'Close');
		header.append(title, time, close);

		const body = document.createElement('div');
		body.className = 'toast-body';
		const link = document.createElement('a');
		link.className = 'text-decoration-none text-dark';
		link.href = notification.url;
		link.textContent = notification.message;
		body.appendChild(link);
		toast.append(header, body);
		close.addEventListener('click', () => toast.remove());
		liveNotifications.appendChild(toast);

		window.setTimeout(() => toast.remove(), 15000);
		fetch(`${liveNotifications.dataset.readUrl}/${notification.id}/read`, {
			method: 'POST',
			headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' },
		});
	};

	const pollNotifications = async () => {
		try {
			const response = await fetch(feedUrl, { headers: { Accept: 'application/json' } });
			if (!response.ok) return;
			const payload = await response.json();
			payload.notifications.forEach(showNotification);
		} catch (error) {
			console.debug('Live notification polling unavailable.', error);
		}
	};

	pollNotifications();
	window.setInterval(pollNotifications, 5000);
};

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', startLiveNotifications, { once: true });
} else {
	startLiveNotifications();
}
