/**
 * Questionnaire start gate: the start button reveals the multi-step form.
 *
 * @package Stature
 */

import { onReady } from '@stature/utils';

const SELECTOR = '[data-questionnaire]';

const firstField = (form) =>
  form.querySelector(
    '.gfield:not(.gform_validation_container) input:not([type=hidden]):not([type=submit]):not([type=button]), .gfield:not(.gform_validation_container) textarea, .gfield:not(.gform_validation_container) select',
  );

const initQuestionnaire = (root) => {
  if (root.dataset.questionnaireInitialised) return;

  const start = root.querySelector('[data-questionnaire-start]');
  const intro = root.querySelector('[data-questionnaire-panel="intro"]');
  const form = root.querySelector('[data-questionnaire-panel="form"]');

  if (!start || !intro || !form) return;

  root.dataset.questionnaireInitialised = 'true';

  start.addEventListener('click', () => {
    intro.hidden = true;
    form.hidden = false;
    start.setAttribute('aria-expanded', 'true');

    root.scrollIntoView({ behavior: 'smooth', block: 'start' });

    const field = firstField(form);
    if (field) field.focus({ preventScroll: true });
  });
};

onReady(SELECTOR, initQuestionnaire);
