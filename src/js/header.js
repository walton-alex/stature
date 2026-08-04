/**
 * Mobile navigation overlay.
 *
 * @package Stature
 */

import { applyAll, compose, cssVar, onReady } from '@stature/utils';

const SELECTOR = '.stature-header';
const TOGGLE_SELECTOR = '.stature-header__toggle';
const CLOSE_SELECTOR = '.stature-header__close';
const NAV_SELECTOR = '.stature-header__nav';
const LINK_SELECTOR = 'a[href]';
const FOCUSABLE_SELECTOR =
  'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';
const OPEN_CLASS = 'is-nav-open';

const focusableWithin = (root) =>
  [...root.querySelectorAll(FOCUSABLE_SELECTOR)].filter(
    (el) => el.getClientRects().length > 0,
  );

const createSetOpen = (header, toggle) => (open) => {
  header.classList.toggle(OPEN_CLASS, open);
  toggle.setAttribute('aria-expanded', String(open));
  return open;
};

const withScrollLock = (setOpen) => (open) => {
  document.documentElement.style.overflow = open ? 'hidden' : '';
  return setOpen(open);
};

const withDialogSemantics = (nav) => (setOpen) => (open) => {
  if (open) {
    nav.setAttribute('role', 'dialog');
    nav.setAttribute('aria-modal', 'true');
  } else {
    nav.removeAttribute('role');
    nav.removeAttribute('aria-modal');
  }

  return setOpen(open);
};

const withFocusMove = (onOpen, onClose) => (setOpen) => (open) => {
  const result = setOpen(open);
  requestAnimationFrame(() => (open ? onOpen : onClose).focus());
  return result;
};

const withToggleButton = (toggle) => (setOpen) => {
  toggle.addEventListener('click', () => setOpen(true));
  return setOpen;
};

const withCloseButton = (close) => (setOpen) => {
  close.addEventListener('click', () => setOpen(false));
  return setOpen;
};

const withEscapeKey = (isOpen) => (setOpen) => {
  document.addEventListener('keydown', ({ key }) => {
    if (isOpen() && key === 'Escape') setOpen(false);
  });
  return setOpen;
};

const withLinkDismiss = (nav, isOpen) => (setOpen) => {
  nav.addEventListener('click', ({ target }) => {
    if (isOpen() && target.closest(LINK_SELECTOR)) setOpen(false);
  });
  return setOpen;
};

const withFocusTrap = (nav, isOpen) => (setOpen) => {
  document.addEventListener('keydown', (event) => {
    if (!isOpen() || event.key !== 'Tab') return;

    const items = focusableWithin(nav);
    if (!items.length) return;

    const first = items[0];
    const last = items.at(-1);
    const { activeElement } = document;

    if (event.shiftKey && activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });
  return setOpen;
};

const withBreakpointReset = (query, isOpen) => (setOpen) => {
  query.addEventListener('change', ({ matches }) => {
    if (matches && isOpen()) setOpen(false);
  });
  return setOpen;
};

const initHeader = (header) => {
  if (header.dataset.navInitialised) return;

  const toggle = header.querySelector(TOGGLE_SELECTOR);
  const close = header.querySelector(CLOSE_SELECTOR);
  const nav = header.querySelector(NAV_SELECTOR);

  if (!toggle || !close || !nav) return;

  header.dataset.navInitialised = 'true';

  const isOpen = () => header.classList.contains(OPEN_CLASS);
  const desktop = window.matchMedia(
    `(min-width: ${cssVar('--bp-desktop', '1024px')})`,
  );

  compose(
    applyAll([
      withToggleButton(toggle),
      withCloseButton(close),
      withEscapeKey(isOpen),
      withLinkDismiss(nav, isOpen),
      withFocusTrap(nav, isOpen),
      withBreakpointReset(desktop, isOpen),
    ]),
    withScrollLock,
    withDialogSemantics(nav),
    withFocusMove(close, toggle),
  )(createSetOpen(header, toggle));
};

onReady(SELECTOR, initHeader);
