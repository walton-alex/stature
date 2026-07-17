/**
 * Website Credibility Scorecard.
 *
 * A four-stage, no-reload lead magnet: intro → six section pages (one dimension
 * of five questions each) → email gate → results. Copy, questions, scoring and
 * band messages are taken verbatim from the client brief's prototype. The gate
 * submission POSTs to admin-ajax, which stores a Gravity Forms entry and fires
 * its notification before the results are revealed.
 *
 * @package Stature
 */

import { applyAll, compose, onReady } from '@stature/utils';

const SELECTOR = '[data-scorecard]';
const APP_SELECTOR = '#sc-app';
const START_SELECTOR = '.js-start';
const BACK_SELECTOR = '.js-back';
const NEXT_SELECTOR = '.js-next';
const SUBMIT_SELECTOR = '.js-submit';
const RESTART_SELECTOR = '.js-restart';
const QUESTIONS_SELECTOR = '.sc-questions';
const QBLOCK_SELECTOR = '.sc-qblock';
const OPTION_SELECTOR = '.sc-option';
const PROGRESS_SELECTOR = '.sc-progress__fill';
const FIRST_NAME_SELECTOR = '#sc-fn';
const EMAIL_SELECTOR = '#sc-em';

const DIMENSIONS = [
  {
    name: 'First impressions & design',
    questions: [
      'Does your website load quickly on both desktop and mobile?',
      'Does your website look modern and professionally designed?',
      'Is your branding — logo, colours, typography — consistent throughout the site?',
      "Does your homepage immediately communicate that you're a specialist recruitment agency, not a generalist?",
      'Would a prospect landing on your site for the first time feel confident enough to stay and read further?',
    ],
  },
  {
    name: 'Positioning & niche clarity',
    questions: [
      'Does your homepage make it immediately clear which sector or sectors you specialise in?',
      'Can a prospect tell within 10 seconds who your ideal client is?',
      'Does your website clearly explain what makes your agency different from competitors?',
      "Is your agency's niche reflected consistently across every page of your site?",
      'Does your website speak directly to the clients you want, rather than trying to appeal to everyone?',
    ],
  },
  {
    name: 'Copy & messaging',
    questions: [
      'Does your homepage headline clearly communicate what you do and who you do it for?',
      "Is your website copy written from the client's perspective, rather than your own?",
      'Does your copy speak to the specific challenges your ideal client faces?',
      'Is your website free from generic recruitment industry language and clichés?',
      'Does your copy give prospects a clear reason to choose you over another agency?',
    ],
  },
  {
    name: 'Social proof & trust signals',
    questions: [
      'Does your website feature testimonials or reviews from clients?',
      'Are your testimonials attributed to named individuals and companies, rather than anonymous?',
      'Does your website showcase case studies or examples of completed work?',
      'Does your website display any relevant accreditations, partnerships, or industry affiliations?',
      "Is there clear evidence on your website of the sectors and geographies you've successfully placed in?",
    ],
  },
  {
    name: 'User experience & navigation',
    questions: [
      'Is your website easy to navigate, with a clear and logical menu structure?',
      "Can a prospect find what they're looking for within two clicks from the homepage?",
      'Is your website fully optimised for mobile devices?',
      'Are all links, forms, and interactive elements working correctly?',
      'Is your website free from outdated content, broken pages, or irrelevant information?',
    ],
  },
  {
    name: 'Lead generation & CTAs',
    questions: [
      'Does every page of your website have a clear next step for the visitor?',
      'Is it immediately obvious how a prospect can get in touch with your agency?',
      'Does your website make contacting you feel low-effort and low-commitment?',
      'Does your website have a contact form or enquiry mechanism beyond just an email address?',
      'Does your website actively encourage prospects to take action, rather than passively presenting information?',
    ],
  },
];

// An option's index is its score, so the last option carries the most points.
const OPTIONS = ['No', 'Partially', 'Yes'];
const MAX_PER_QUESTION = OPTIONS.length - 1;
const LAST_DIM = DIMENSIONS.length - 1;
const TOTAL_QUESTIONS = DIMENSIONS.reduce(
  (sum, { questions }) => sum + questions.length,
  0,
);
const MAX_SCORE = TOTAL_QUESTIONS * MAX_PER_QUESTION;

// Ordered low → high; the first band the score fits under wins.
const BANDS = [
  {
    max: 20,
    label: 'Critical',
    cls: 'critical',
    msg: "Your website is actively working against you. Prospects landing on your site right now are unlikely to see the agency you've built — and that gap is costing you clients. The good news: the issues are fixable, and the improvements are clear.",
  },
  {
    max: 40,
    label: 'Developing',
    cls: 'developing',
    msg: 'You have some foundations in place, but there are significant gaps that are undermining your credibility with potential clients. A focused review of your weakest dimensions would have a meaningful impact on how your agency is perceived online.',
  },
  {
    max: 54,
    label: 'Strong',
    cls: 'strong',
    msg: "Your website is in good shape — you're making a credible impression on most prospects. A targeted set of improvements to your weaker areas could sharpen things further and help you stand out in a competitive market.",
  },
  {
    max: Infinity,
    label: 'Excellent',
    cls: 'excellent',
    msg: 'Your website is doing its job. It reflects the quality of your agency and gives prospects a clear, credible picture of what you do. Keep it maintained and revisit it as your positioning evolves.',
  },
];

const DIM_FILLS = [
  { max: 3, cls: ' sc-dim-fill--low' },
  { max: 6, cls: ' sc-dim-fill--mid' },
  { max: Infinity, cls: '' },
];

// Only a patch that moves the visitor should scroll them back to the top.
const NAV_KEYS = ['stage', 'dimIdx'];

const ESCAPES = {
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
};

const escapeHtml = (value) =>
  String(value).replace(/[&<>"']/g, (char) => ESCAPES[char]);

const bandFor = (score) => BANDS.find(({ max }) => score <= max);
const dimFillFor = (score) => DIM_FILLS.find(({ max }) => score <= max).cls;

const createState = () => ({
  stage: 'intro',
  dimIdx: 0,
  answers: DIMENSIONS.map(({ questions }) => questions.map(() => null)),
  firstName: '',
  email: '',
  submitting: false,
  error: '',
});

const dimMax = (d) => DIMENSIONS[d].questions.length * MAX_PER_QUESTION;
const dimScore = (state, d) =>
  state.answers[d].reduce((sum, value) => sum + (value ?? 0), 0);
const totalScore = (state) =>
  state.answers.reduce((sum, _, d) => sum + dimScore(state, d), 0);
const dimComplete = (state, d) =>
  state.answers[d].every((value) => value !== null);
const answeredCount = (state) =>
  state.answers.flat().filter((value) => value !== null).length;
const progressPct = (state) => (answeredCount(state) / TOTAL_QUESTIONS) * 100;
const weakestDim = (state) =>
  DIMENSIONS.map(({ name }, d) => ({
    name,
    score: dimScore(state, d),
    max: dimMax(d),
  })).sort((a, b) => a.score - b.score)[0];

const isNavigation = (patch) => NAV_KEYS.some((key) => key in patch);
const isValidGate = (firstName, email) =>
  Boolean(firstName) && Boolean(email) && email.includes('@');

const introView = () => `
  <div class="sc-intro">
    <div class="stature-eyebrow stature-label">Stature · Free tool</div>
    <h1 class="stature-heading stature-heading--h1 sc-intro__heading">The website credibility scorecard</h1>
    <p class="stature-lead sc-intro__lead">Most specialist recruitment agencies have a credibility problem — not with their work, but with their website. This scorecard shows you exactly where yours stands, and where it's letting your agency down.</p>
    <p class="stature-lead sc-intro__lead">Score your website across six dimensions in around four minutes. You'll receive an instant breakdown with a clear picture of where to focus first.</p>
    <div class="stature-tool-meta sc-intro__meta">
      <span class="stature-tool-meta__item">30 questions, six dimensions</span>
      <span class="stature-tool-meta__item">About 4 minutes</span>
      <span class="stature-tool-meta__item">Instant results</span>
    </div>
    <button type="button" class="stature-btn stature-btn--lg stature-btn--primary sc-intro__start js-start">Start the scorecard<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span></button>
  </div>`;

const optionView = (selected, qi) => (label, oi) => {
  const on = selected === oi;
  return `<button type="button" class="sc-option${on ? ' is-selected' : ''}" data-q="${qi}" data-o="${oi}" aria-pressed="${on}"><span class="sc-option__dot"></span><span class="sc-option__text">${label}</span></button>`;
};

const questionView = (state) => (question, qi) => `
  <div class="sc-qblock" data-q="${qi}">
    <p class="sc-question">${question}</p>
    <div class="sc-options">
      ${OPTIONS.map(optionView(state.answers[state.dimIdx][qi], qi)).join('')}
    </div>
  </div>`;

const questionsView = ({ state }) => `
  <div class="sc-card">
    <div class="sc-step-label">Step ${state.dimIdx + 1} of ${DIMENSIONS.length}</div>
    <div class="sc-progress"><span class="sc-progress__fill" style="width:${progressPct(state)}%"></span></div>
    <div class="stature-eyebrow stature-label sc-section-title">${DIMENSIONS[state.dimIdx].name}</div>
    <div class="sc-questions">
      ${DIMENSIONS[state.dimIdx].questions.map(questionView(state)).join('')}
    </div>
    <div class="sc-nav">
      ${state.dimIdx > 0 ? '<button type="button" class="stature-btn stature-btn--md stature-btn--secondary js-back">Back</button>' : ''}
      <button type="button" class="stature-btn stature-btn--md stature-btn--primary js-next"${dimComplete(state, state.dimIdx) ? '' : ' disabled'}>${state.dimIdx === LAST_DIM ? 'See my results' : 'Next'}</button>
    </div>
  </div>`;

const gateView = ({ state }) => `
  <div class="sc-card">
    <div class="stature-eyebrow stature-label">Almost there</div>
    <h2 class="stature-heading stature-heading--h3 sc-heading">Where shall we send your score?</h2>
    <p class="sc-lead">Enter your details to see your full breakdown, your weakest dimension, and what to focus on first.</p>
    <div class="sc-field">
      <label for="sc-fn">First name</label>
      <input type="text" id="sc-fn" autocomplete="given-name" placeholder="Alex" value="${escapeHtml(state.firstName)}">
    </div>
    <div class="sc-field">
      <label for="sc-em">Work email</label>
      <input type="email" id="sc-em" autocomplete="email" placeholder="alex@youragency.com" value="${escapeHtml(state.email)}">
    </div>
    <p class="sc-fineprint">No spam, ever. Just your result and the occasional useful note. Unsubscribe anytime.</p>
    ${state.error ? `<p class="sc-error" role="alert">${escapeHtml(state.error)}</p>` : ''}
    <div class="sc-nav">
      <button type="button" class="stature-btn stature-btn--md stature-btn--secondary js-back">Back</button>
      <button type="button" class="stature-btn stature-btn--md stature-btn--primary js-submit"${state.submitting ? ' disabled' : ''}>${state.submitting ? 'Sending…' : 'See my results'}</button>
    </div>
  </div>`;

const breakdownRowView =
  (state) =>
  ({ name }, d) => {
    const score = dimScore(state, d);
    return `
    <div class="sc-dim-row">
      <span class="sc-dim-name">${name}</span>
      <span class="sc-dim-track"><span class="sc-dim-fill${dimFillFor(score)}" style="width:${Math.round((score / dimMax(d)) * 100)}%"></span></span>
      <span class="sc-dim-score">${score}/${dimMax(d)}</span>
    </div>`;
  };

// Top band already has a strong site — point them at keeping it that way, rather than a new project.
const ctaFor = (band, cfg) =>
  band.cls === 'excellent'
    ? {
        title: 'Keep it going well',
        text: "Your website's already doing its job. Our hosting & support keeps it fast, secure and quietly improving — so it stays that way.",
        label: 'Explore hosting & support',
        url: cfg.hostingUrl,
      }
    : {
        title: 'Ready to close the gap?',
        text: "Tell us about your agency and your website — we'll take a look and give you a clear picture of what needs to change and why.",
        label: 'Start the project questionnaire',
        url: cfg.ctaUrl,
      };

const resultsView = ({ state, cfg }) => {
  const score = totalScore(state);
  const band = bandFor(score);
  const weakest = weakestDim(state);
  const cta = ctaFor(band, cfg);

  return `
  <div class="sc-card">
    <div class="stature-eyebrow stature-label">Your results, ${escapeHtml(state.firstName)}</div>
    <h2 class="stature-heading stature-heading--h3 sc-heading">Website credibility scorecard</h2>
    <div class="sc-score"><span class="sc-score__value">${score}</span><span class="sc-score__max">/ ${MAX_SCORE}</span></div>
    <div class="sc-band sc-band--${band.cls}">${band.label}</div>
    <div class="sc-band-msg">${band.msg}</div>
    <div class="sc-sublabel">Breakdown by dimension</div>
    <div class="sc-breakdown">
      ${DIMENSIONS.map(breakdownRowView(state)).join('')}
    </div>
    <hr class="sc-rule">
    <div class="sc-sublabel">Your weakest area</div>
    <p class="sc-weakest">Your lowest score is in <strong>${escapeHtml(weakest.name)}</strong> (${weakest.score}/${weakest.max}). This is the area most likely to be undermining your credibility with prospects right now — and the best place to start.</p>
    <div class="sc-cta">
      <h3 class="sc-cta__title">${cta.title}</h3>
      <p class="sc-cta__text">${cta.text}</p>
      <a class="stature-btn stature-btn--md stature-btn--primary is-on-navy" href="${escapeHtml(cta.url)}">${cta.label}</a>
    </div>
    <button type="button" class="sc-restart js-restart">Start over</button>
  </div>`;
};

const VIEWS = {
  intro: introView,
  questions: questionsView,
  gate: gateView,
  results: resultsView,
};

const submitGate = async ({ app, state, cfg, dispatch }) => {
  if (state.submitting) return;

  const firstName = app.querySelector(FIRST_NAME_SELECTOR).value.trim();
  const email = app.querySelector(EMAIL_SELECTOR).value.trim();

  if (!isValidGate(firstName, email)) {
    dispatch({
      firstName,
      email,
      error: 'Please enter your first name and a valid work email.',
    });
    return;
  }

  dispatch({ firstName, email, error: '', submitting: true });

  const score = totalScore(state);
  const breakdown = DIMENSIONS.map(
    ({ name }, d) => `${name}: ${dimScore(state, d)}/${dimMax(d)}`,
  ).join('\n');

  try {
    const response = await fetch(cfg.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'stature_scorecard',
        nonce: cfg.nonce,
        first_name: firstName,
        email,
        score: String(score),
        band: bandFor(score).label,
        breakdown,
        source_url: window.location.href,
      }),
    });

    const data = await response.json().catch(() => null);

    // A validation failure keeps the user on the gate to correct it.
    if (response.status === 400) {
      dispatch({
        submitting: false,
        error:
          data?.data?.message ??
          'Please enter your first name and a valid work email.',
      });
      return;
    }

    // On success — or a transient server/network error we shouldn't punish the
    // user for — reveal the results they earned.
    if (!data?.success) {
      console.warn(
        'Scorecard: lead capture did not confirm; showing results anyway.',
      );
    }
  } catch (error) {
    console.warn(
      'Scorecard: lead capture request failed; showing results anyway.',
      error,
    );
  }

  dispatch({ submitting: false, stage: 'results' });
};

const withStart = ({ app, dispatch }) => {
  app
    .querySelector(START_SELECTOR)
    .addEventListener('click', () =>
      dispatch({ stage: 'questions', dimIdx: 0 }),
    );
};

// Answers land in state and the DOM directly rather than through dispatch, so
// choosing an option doesn't re-render the page under the visitor's cursor.
const withOptionClicks = ({ app, state }) => {
  app
    .querySelector(QUESTIONS_SELECTOR)
    .addEventListener('click', ({ target }) => {
      const btn = target.closest(OPTION_SELECTOR);
      if (!btn) return;

      state.answers[state.dimIdx][Number(btn.dataset.q)] = Number(
        btn.dataset.o,
      );

      btn
        .closest(QBLOCK_SELECTOR)
        .querySelectorAll(OPTION_SELECTOR)
        .forEach((el) => {
          const on = el === btn;
          el.classList.toggle('is-selected', on);
          el.setAttribute('aria-pressed', String(on));
        });

      app.querySelector(NEXT_SELECTOR).disabled = !dimComplete(
        state,
        state.dimIdx,
      );
      app.querySelector(PROGRESS_SELECTOR).style.width =
        `${progressPct(state)}%`;
    });
};

const withQuestionsNav = ({ app, state, dispatch }) => {
  // The first section renders no Back — there is nothing behind it to return to.
  app
    .querySelector(BACK_SELECTOR)
    ?.addEventListener('click', () => dispatch({ dimIdx: state.dimIdx - 1 }));

  app.querySelector(NEXT_SELECTOR).addEventListener('click', () => {
    if (!dimComplete(state, state.dimIdx)) return;
    dispatch(
      state.dimIdx < LAST_DIM
        ? { dimIdx: state.dimIdx + 1 }
        : { stage: 'gate' },
    );
  });
};

const withGateBack = ({ app, dispatch }) => {
  app
    .querySelector(BACK_SELECTOR)
    .addEventListener('click', () =>
      dispatch({ stage: 'questions', dimIdx: LAST_DIM, error: '' }),
    );
};

const withGateSubmit = (ctx) => {
  ctx.app
    .querySelector(SUBMIT_SELECTOR)
    .addEventListener('click', () => submitGate(ctx));
};

const withGateEnterKey = (ctx) => {
  ctx.app.querySelector(EMAIL_SELECTOR).addEventListener('keydown', (event) => {
    if (event.key === 'Enter') submitGate(ctx);
  });
};

const withRestart = ({ app, dispatch }) => {
  app
    .querySelector(RESTART_SELECTOR)
    .addEventListener('click', () => dispatch(createState()));
};

const BINDERS = {
  intro: applyAll([withStart]),
  questions: applyAll([withOptionClicks, withQuestionsNav]),
  gate: applyAll([withGateBack, withGateSubmit, withGateEnterKey]),
  results: applyAll([withRestart]),
};

const createSetState = (state) => (patch) => Object.assign(state, patch);

const withRender = (ctx) => (setState) => (patch) => {
  const next = setState(patch);
  ctx.app.innerHTML = VIEWS[next.stage](ctx);
  return next;
};

const withBindings = (ctx) => (setState) => (patch) => {
  const next = setState(patch);
  BINDERS[next.stage](ctx);
  return next;
};

const withScrollToTop = (root) => (setState) => (patch) => {
  const next = setState(patch);
  if (isNavigation(patch)) {
    root.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  return next;
};

const initScorecard = (root) => {
  if (root.dataset.scorecardInitialised) return;

  const app = root.querySelector(APP_SELECTOR);
  if (!app) return;

  root.dataset.scorecardInitialised = 'true';

  const state = createState();
  const ctx = {
    app,
    state,
    cfg: {
      ajaxUrl: root.dataset.ajaxUrl || '',
      nonce: root.dataset.nonce || '',
      ctaUrl: root.dataset.ctaUrl || '#',
      hostingUrl: root.dataset.hostingUrl || '#',
    },
    // Late-bound so binders dispatch through the fully decorated setter.
    dispatch: (patch) => setState(patch),
  };

  const setState = compose(
    withScrollToTop(root),
    withBindings(ctx),
    withRender(ctx),
  )(createSetState(state));

  setState({});
};

onReady(SELECTOR, initScorecard);
