/**
 * Shared front-end utilities.
 *
 * @package Stature
 */

export const onReady = (selector, init) => {
	const run = (root = document) => root.querySelectorAll(selector).forEach(init);

	if (window.acf && typeof window.acf.addAction === 'function') {
		window.acf.addAction('render_block_preview', (block) => {
			if (!block[0]) return;
			run(block[0]);
		});
	} else if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => run());
	} else {
		run();
	}
};

export const withDebounce = (fn, delay) => {
	let timer;
	const debounced = (...args) => {
		clearTimeout(timer);
		timer = setTimeout(() => fn(...args), delay);
	};
	debounced.cancel = () => clearTimeout(timer);
	return debounced;
};

export const compose =
	(...fns) =>
	(value) =>
		fns.reduceRight((acc, fn) => fn(acc), value);

export const applyAll = (enhancers) => (value) => {
	enhancers.forEach((enhance) => enhance(value));
	return value;
};

export const cssVar = (name, fallback = '') =>
	getComputedStyle(document.documentElement).getPropertyValue(name).trim() || fallback;
