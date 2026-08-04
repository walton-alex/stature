!function(){function e(e,t,s,a){Object.defineProperty(e,t,{get:s,set:a,enumerable:!0,configurable:!0})}var t="u">typeof globalThis?globalThis:"u">typeof self?self:"u">typeof window?window:"u">typeof global?global:{},s={},a={},r=t.parcelRequire2c17;null==r&&((r=function(e){if(e in s)return s[e].exports;if(e in a){var t=a[e];delete a[e];var r={id:e,exports:{}};return s[e]=r,t.call(r.exports,r,r.exports),r.exports}var i=Error("Cannot find module '"+e+"'");throw i.code="MODULE_NOT_FOUND",i}).register=function(e,t){a[e]=t},t.parcelRequire2c17=r),(0,r.register)("3Fw4A",function(t,s){e(t.exports,"onReady",function(){return a}),e(t.exports,"compose",function(){return r}),e(t.exports,"applyAll",function(){return i}),e(t.exports,"cssVar",function(){return o});let a=(e,t)=>{let s=(s=document)=>s.querySelectorAll(e).forEach(t);window.acf&&"function"==typeof window.acf.addAction?window.acf.addAction("render_block_preview",e=>{e[0]&&s(e[0])}):"loading"===document.readyState?document.addEventListener("DOMContentLoaded",()=>s()):s()},r=(...e)=>t=>e.reduceRight((e,t)=>t(e),t),i=e=>t=>(e.forEach(e=>e(t)),t),o=(e,t="")=>getComputedStyle(document.documentElement).getPropertyValue(e).trim()||t});var i=r("3Fw4A");let o=".js-back",n=".js-next",l=".sc-option",c="#sc-em",d=[{name:"First impressions & design",questions:["Does your website load quickly on both desktop and mobile?","Does your website look modern and professionally designed?","Is your branding — logo, colours, typography — consistent throughout the site?","Does your homepage immediately communicate that you're a specialist recruitment agency, not a generalist?","Would a prospect landing on your site for the first time feel confident enough to stay and read further?"]},{name:"Positioning & niche clarity",questions:["Does your homepage make it immediately clear which sector or sectors you specialise in?","Can a prospect tell within 10 seconds who your ideal client is?","Does your website clearly explain what makes your agency different from competitors?","Is your agency's niche reflected consistently across every page of your site?","Does your website speak directly to the clients you want, rather than trying to appeal to everyone?"]},{name:"Copy & messaging",questions:["Does your homepage headline clearly communicate what you do and who you do it for?","Is your website copy written from the client's perspective, rather than your own?","Does your copy speak to the specific challenges your ideal client faces?","Is your website free from generic recruitment industry language and clichés?","Does your copy give prospects a clear reason to choose you over another agency?"]},{name:"Social proof & trust signals",questions:["Does your website feature testimonials or reviews from clients?","Are your testimonials attributed to named individuals and companies, rather than anonymous?","Does your website showcase case studies or examples of completed work?","Does your website display any relevant accreditations, partnerships, or industry affiliations?","Is there clear evidence on your website of the sectors and geographies you've successfully placed in?"]},{name:"User experience & navigation",questions:["Is your website easy to navigate, with a clear and logical menu structure?","Can a prospect find what they're looking for within two clicks from the homepage?","Is your website fully optimised for mobile devices?","Are all links, forms, and interactive elements working correctly?","Is your website free from outdated content, broken pages, or irrelevant information?"]},{name:"Lead generation & CTAs",questions:["Does every page of your website have a clear next step for the visitor?","Is it immediately obvious how a prospect can get in touch with your agency?","Does your website make contacting you feel low-effort and low-commitment?","Does your website have a contact form or enquiry mechanism beyond just an email address?","Does your website actively encourage prospects to take action, rather than passively presenting information?"]}],u=["No","Partially","Yes"],p=u.length-1,m=d.length-1,y=d.reduce((e,{questions:t})=>e+t.length,0),h=y*p,b=[{max:20,label:"Critical",cls:"critical",msg:"Your website is actively working against you. Prospects landing on your site right now are unlikely to see the agency you've built — and that gap is costing you clients. The good news: the issues are fixable, and the improvements are clear."},{max:40,label:"Developing",cls:"developing",msg:"You have some foundations in place, but there are significant gaps that are undermining your credibility with potential clients. A focused review of your weakest dimensions would have a meaningful impact on how your agency is perceived online."},{max:54,label:"Strong",cls:"strong",msg:"Your website is in good shape — you're making a credible impression on most prospects. A targeted set of improvements to your weaker areas could sharpen things further and help you stand out in a competitive market."},{max:1/0,label:"Excellent",cls:"excellent",msg:"Your website is doing its job. It reflects the quality of your agency and gives prospects a clear, credible picture of what you do. Keep it maintained and revisit it as your positioning evolves."}],g=[{max:3,cls:" sc-dim-fill--low"},{max:6,cls:" sc-dim-fill--mid"},{max:1/0,cls:""}],w=["stage","dimIdx"],f={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"},v=e=>String(e).replace(/[&<>"']/g,e=>f[e]),x=e=>b.find(({max:t})=>e<=t),k=()=>({stage:"intro",dimIdx:0,answers:d.map(({questions:e})=>e.map(()=>null)),firstName:"",email:"",submitting:!1,error:""}),q=e=>d[e].questions.length*p,$=(e,t)=>e.answers[t].reduce((e,t)=>e+(t??0),0),_=e=>e.answers.reduce((t,s,a)=>t+$(e,a),0),S=(e,t)=>e.answers[t].every(e=>null!==e),I=e=>e.answers.flat().filter(e=>null!==e).length/y*100,j={intro:()=>`
  <div class="sc-intro">
    <div class="stature-eyebrow stature-label">Stature \xb7 Free tool</div>
    <h1 class="stature-heading stature-heading--h1 sc-intro__heading">The website credibility scorecard</h1>
    <p class="stature-lead sc-intro__lead">Most specialist recruitment agencies have a credibility problem \u{2014} not with their work, but with their website. This scorecard shows you exactly where yours stands, and where it's letting your agency down.</p>
    <p class="stature-lead sc-intro__lead">Score your website across six dimensions in around four minutes. You'll receive an instant breakdown with a clear picture of where to focus first.</p>
    <div class="stature-tool-meta sc-intro__meta">
      <span class="stature-tool-meta__item">30 questions, six dimensions</span>
      <span class="stature-tool-meta__item">About 4 minutes</span>
      <span class="stature-tool-meta__item">Instant results</span>
    </div>
    <button type="button" class="stature-btn stature-btn--lg stature-btn--primary sc-intro__start js-start">Start the scorecard<span class="stature-btn__arrow" aria-hidden="true">&rarr;</span></button>
  </div>`,questions:({state:e})=>`
  <div class="sc-card">
    <div class="sc-step-label">Step ${e.dimIdx+1} of ${d.length}</div>
    <div class="sc-progress"><span class="sc-progress__fill" style="width:${I(e)}%"></span></div>
    <div class="stature-eyebrow stature-label sc-section-title">${d[e.dimIdx].name}</div>
    <div class="sc-questions">
      ${d[e.dimIdx].questions.map((t,s)=>{let a;return`
  <div class="sc-qblock" data-q="${s}">
    <p class="sc-question">${t}</p>
    <div class="sc-options">
      ${u.map((a=e.answers[e.dimIdx][s],(e,t)=>{let r=a===t;return`<button type="button" class="sc-option${r?" is-selected":""}" data-q="${s}" data-o="${t}" aria-pressed="${r}"><span class="sc-option__dot"></span><span class="sc-option__text">${e}</span></button>`})).join("")}
    </div>
  </div>`}).join("")}
    </div>
    <div class="sc-nav">
      ${e.dimIdx>0?'<button type="button" class="stature-btn stature-btn--md stature-btn--secondary js-back">Back</button>':""}
      <button type="button" class="stature-btn stature-btn--md stature-btn--primary js-next"${S(e,e.dimIdx)?"":" disabled"}>${e.dimIdx===m?"See my results":"Next"}</button>
    </div>
  </div>`,gate:({state:e})=>`
  <div class="sc-card">
    <div class="stature-eyebrow stature-label">Almost there</div>
    <h2 class="stature-heading stature-heading--h3 sc-heading">Where shall we send your score?</h2>
    <p class="sc-lead">Enter your details to see your full breakdown, your weakest dimension, and what to focus on first.</p>
    <div class="sc-field">
      <label for="sc-fn">First name</label>
      <input type="text" id="sc-fn" autocomplete="given-name" placeholder="Alex" value="${v(e.firstName)}">
    </div>
    <div class="sc-field">
      <label for="sc-em">Work email</label>
      <input type="email" id="sc-em" autocomplete="email" placeholder="alex@youragency.com" value="${v(e.email)}">
    </div>
    <p class="sc-fineprint">No spam, ever. Just your result and the occasional useful note. Unsubscribe anytime.</p>
    ${e.error?`<p class="sc-error" role="alert">${v(e.error)}</p>`:""}
    <div class="sc-nav">
      <button type="button" class="stature-btn stature-btn--md stature-btn--secondary js-back">Back</button>
      <button type="button" class="stature-btn stature-btn--md stature-btn--primary js-submit"${e.submitting?" disabled":""}>${e.submitting?"Sending…":"See my results"}</button>
    </div>
  </div>`,results:({state:e,cfg:t})=>{let s=_(e),a=x(s),r=d.map(({name:t},s)=>({name:t,score:$(e,s),max:q(s)})).sort((e,t)=>e.score-t.score)[0],i="excellent"===a.cls?{title:"Keep it going well",text:"Your website's already doing its job. Our hosting & support keeps it fast, secure and quietly improving — so it stays that way.",label:"Explore hosting & support",url:t.hostingUrl,external:!1}:{title:"Want to talk it through?",text:"Book a free call and we'll walk through your scorecard together — what's costing you credibility, and what to fix first.",label:"Book a call",url:t.reviewUrl,external:!0};return`
  <div class="sc-card">
    <div class="stature-eyebrow stature-label">Your results, ${v(e.firstName)}</div>
    <h2 class="stature-heading stature-heading--h3 sc-heading">Website credibility scorecard</h2>
    <div class="sc-score"><span class="sc-score__value">${s}</span><span class="sc-score__max">/ ${h}</span></div>
    <div class="sc-band sc-band--${a.cls}">${a.label}</div>
    <div class="sc-band-msg">${a.msg}</div>
    <div class="sc-sublabel">Breakdown by dimension</div>
    <div class="sc-breakdown">
      ${d.map(({name:t},s)=>{let a=$(e,s);return`
    <div class="sc-dim-row">
      <span class="sc-dim-name">${t}</span>
      <span class="sc-dim-track"><span class="sc-dim-fill${g.find(({max:e})=>a<=e).cls}" style="width:${Math.round(a/q(s)*100)}%"></span></span>
      <span class="sc-dim-score">${a}/${q(s)}</span>
    </div>`}).join("")}
    </div>
    <hr class="sc-rule">
    <div class="sc-sublabel">Your weakest area</div>
    <p class="sc-weakest">Your lowest score is in <strong>${v(r.name)}</strong> (${r.score}/${r.max}). This is the area most likely to be undermining your credibility with prospects right now \u{2014} and the best place to start.</p>
    <div class="sc-cta">
      <h3 class="sc-cta__title">${i.title}</h3>
      <p class="sc-cta__text">${i.text}</p>
      <a class="stature-btn stature-btn--md stature-btn--primary is-on-navy" href="${v(i.url)}"${i.external?' target="_blank" rel="noopener"':""}>${i.label}</a>
    </div>
    <button type="button" class="sc-restart js-restart">Start over</button>
  </div>`}},A=async({app:e,state:t,cfg:s,dispatch:a})=>{if(t.submitting)return;let r=e.querySelector("#sc-fn").value.trim(),i=e.querySelector(c).value.trim();if(!(r&&i&&i.includes("@")))return void a({firstName:r,email:i,error:"Please enter your first name and a valid work email."});a({firstName:r,email:i,error:"",submitting:!0});let o=_(t),n=d.map(({name:e},s)=>`${e}: ${$(t,s)}/${q(s)}`).join("\n");try{let e=await fetch(s.ajaxUrl,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"stature_scorecard",nonce:s.nonce,first_name:r,email:i,score:String(o),band:x(o).label,breakdown:n,source_url:window.location.href})}),t=await e.json().catch(()=>null);if(400===e.status)return void a({submitting:!1,error:t?.data?.message??"Please enter your first name and a valid work email."});t?.success||console.warn("Scorecard: lead capture did not confirm; showing results anyway.")}catch(e){console.warn("Scorecard: lead capture request failed; showing results anyway.",e)}a({submitting:!1,stage:"results"})},D={intro:(0,i.applyAll)([({app:e,dispatch:t})=>{e.querySelector(".js-start").addEventListener("click",()=>t({stage:"questions",dimIdx:0}))}]),questions:(0,i.applyAll)([({app:e,state:t})=>{e.querySelector(".sc-questions").addEventListener("click",({target:s})=>{let a=s.closest(l);a&&(t.answers[t.dimIdx][Number(a.dataset.q)]=Number(a.dataset.o),a.closest(".sc-qblock").querySelectorAll(l).forEach(e=>{let t=e===a;e.classList.toggle("is-selected",t),e.setAttribute("aria-pressed",String(t))}),e.querySelector(n).disabled=!S(t,t.dimIdx),e.querySelector(".sc-progress__fill").style.width=`${I(t)}%`)})},({app:e,state:t,dispatch:s})=>{e.querySelector(o)?.addEventListener("click",()=>s({dimIdx:t.dimIdx-1})),e.querySelector(n).addEventListener("click",()=>{S(t,t.dimIdx)&&s(t.dimIdx<m?{dimIdx:t.dimIdx+1}:{stage:"gate"})})}]),gate:(0,i.applyAll)([({app:e,dispatch:t})=>{e.querySelector(o).addEventListener("click",()=>t({stage:"questions",dimIdx:m,error:""}))},e=>{e.app.querySelector(".js-submit").addEventListener("click",()=>A(e))},e=>{e.app.querySelector(c).addEventListener("keydown",t=>{"Enter"===t.key&&A(e)})}]),results:(0,i.applyAll)([({app:e,dispatch:t})=>{e.querySelector(".js-restart").addEventListener("click",()=>t(k()))}])};(0,i.onReady)("[data-scorecard]",e=>{if(e.dataset.scorecardInitialised)return;let t=e.querySelector("#sc-app");if(!t)return;e.dataset.scorecardInitialised="true";let s=k(),a={app:t,state:s,cfg:{ajaxUrl:e.dataset.ajaxUrl||"",nonce:e.dataset.nonce||"",reviewUrl:e.dataset.reviewUrl||"#",hostingUrl:e.dataset.hostingUrl||"#"},dispatch:e=>r(e)},r=(0,i.compose)(t=>s=>{let a=t(s);return w.some(e=>e in s)&&e.scrollIntoView({behavior:"smooth",block:"start"}),a},e=>t=>{let s=e(t);return D[s.stage](a),s},e=>t=>{let s=e(t);return a.app.innerHTML=j[s.stage](a),s})(e=>Object.assign(s,e));r({})})}();