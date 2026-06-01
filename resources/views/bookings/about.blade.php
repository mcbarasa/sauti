<style>
  .sg-about{background:var(--color-background-secondary);padding:5rem 1.5rem;font-family:var(--font-sans)}
  .sg-container{max-width:1100px;margin:0 auto}
  .sg-label{font-size:0.7rem;letter-spacing:5px;text-transform:uppercase;color:#BA7517;margin-bottom:0.6rem;font-weight:500}
  .sg-title{font-size:clamp(2.2rem,5vw,3.6rem);font-weight:500;letter-spacing:1px;line-height:1;color:var(--color-text-primary);margin-bottom:0.75rem}
  .sg-sub{color:var(--color-text-secondary);font-size:1.05rem;font-weight:400;max-width:520px;line-height:1.7;margin-bottom:3rem}
  .sg-mosaic{display:grid;grid-template-columns:1fr 1fr 1fr;grid-template-rows:200px 200px;gap:8px;margin-bottom:3rem;border-radius:12px;overflow:hidden}
  .sg-img{background:var(--color-background-primary);border:0.5px solid var(--color-border-tertiary);overflow:hidden;position:relative}
  .sg-img.big{grid-column:1/3;grid-row:1/3}
  .sg-img-inner{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem}
  .sg-img-label{position:absolute;bottom:0;left:0;right:0;padding:0.6rem 0.9rem;font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;background:linear-gradient(transparent,rgba(0,0,0,0.55));color:#fff}
  .sg-badge{position:absolute;top:12px;right:12px;background:#EF9F27;color:#633806;font-size:0.68rem;font-weight:500;letter-spacing:2px;padding:4px 10px;border-radius:6px}
  .sg-body{display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;align-items:start}
  .sg-text p{color:var(--color-text-secondary);font-size:0.98rem;line-height:1.8;margin-bottom:1rem}
  .sg-feat-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:1.5rem}
  .sg-feat{background:var(--color-background-primary);border:0.5px solid var(--color-border-tertiary);border-radius:8px;padding:0.7rem 0.9rem;display:flex;align-items:center;gap:10px;font-size:0.85rem;color:var(--color-text-primary)}
  .sg-feat i{font-size:18px;color:#BA7517}
  .sg-rules{display:flex;flex-direction:column;gap:10px}
  .sg-rule{border-radius:10px;padding:1rem 1.1rem;border-left:3px solid;display:flex;gap:12px;align-items:flex-start}
  .sg-rule.warn{background:var(--color-background-warning);border-color:#EF9F27}
  .sg-rule.danger{background:var(--color-background-danger);border-color:#E24B4A}
  .sg-rule.info{background:var(--color-background-info);border-color:#378ADD}
  .sg-rule.success{background:var(--color-background-success);border-color:#639922}
  .sg-rule i{font-size:20px;flex-shrink:0;margin-top:1px}
  .sg-rule.warn i{color:#BA7517}
  .sg-rule.danger i{color:#A32D2D}
  .sg-rule.info i{color:#185FA5}
  .sg-rule.success i{color:#3B6D11}
  .sg-rule-title{font-size:0.82rem;font-weight:500;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:3px;color:var(--color-text-primary)}
  .sg-rule-body{font-size:0.88rem;line-height:1.6;color:var(--color-text-secondary)}
  .sg-rule-body strong{color:var(--color-text-primary);font-weight:500}
  .sg-est{display:inline-flex;align-items:center;gap:8px;background:var(--color-background-primary);border:0.5px solid var(--color-border-tertiary);border-radius:8px;padding:0.5rem 1rem;font-size:0.78rem;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-secondary);margin-top:1.5rem}
  .sg-est i{color:#BA7517;font-size:16px}
  .sg-text span{
    color: #E24B4A;
  }
  @media(max-width:768px){
    .sg-mosaic{grid-template-columns:1fr 1fr;grid-template-rows:160px 160px}
    .sg-img.big{grid-column:1/3;grid-row:1/2}
    .sg-img:nth-child(2){grid-column:1/2;grid-row:2/3}
    .sg-img:nth-child(3){grid-column:2/3;grid-row:2/3}
    .sg-img:nth-child(4){display:none}
    .sg-body{grid-template-columns:1fr}
    .sg-feat-grid{grid-template-columns:1fr 1fr}
  }
  @media(max-width:480px){
    .sg-feat-grid{grid-template-columns:1fr}
    .sg-mosaic{grid-template-rows:140px 140px}
    .sg-about{padding:3.5rem 1rem}
  }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<section class="sg-about" id="about">
  <div class="sg-container">

    <p class="sg-label">About the Studio</p>
    <h2 class="sg-title">Built for the<br>Creative Soul</h2>
    <p class="sg-sub">Sauti Gang Studio is more than a rehearsal space — it's a community where Nairobi's finest artists come to breathe life into their music.</p>

    <!-- Image mosaic -->
    <div class="sg-mosaic">
      <div class="sg-img big">
        <img src="{{ asset('img/photo5.WebP') }}" alt="" style="width:100%;height:100%;object-fit:cover;display:block" onerror="this.style.display='none'">
        <div class="sg-img-inner" style="position:absolute;inset:0;background:var(--color-background-secondary)"><i class="ti ti-microphone-2" style="font-size:3rem;color:#EF9F27;opacity:0.4"></i></div>
        <span class="sg-badge">Main Studio</span>
        <div class="sg-img-label">Rehearsal Suite </div>
      </div>
      <div class="sg-img">
        <img src="{{ asset('img/photo14.WebP') }}" alt="" style="width:100%;height:100%;object-fit:cover;display:block" onerror="this.style.display='none'">
        <div class="sg-img-inner" style="background:var(--color-background-primary)"><i class="ti ti-guitar-pick" style="font-size:2rem;color:#EF9F27;opacity:0.35"></i></div>
        <div class="sg-img-label">Bass</div>
      </div>
      <div class="sg-img" style="grid-column:3/4;grid-row:2/3">
        <img src="{{ asset('img/photo12.WebP') }}" alt="" style="width:100%;height:100%;object-fit:cover;display:block" onerror="this.style.display='none'">
        <div class="sg-img-inner" style="background:var(--color-background-primary)"><i class="ti ti-bulb" style="font-size:2rem;color:#EF9F27;opacity:0.35"></i></div>
        <div class="sg-img-label">Keys</div>
      </div>
    </div>

    <div class="sg-body">

      <!-- Left: about text + features -->
      <div class="sg-text">
        <p>Tucked in the heart of Karen, Nairobi, Sauti Gang Studio was founded with one mission — give every musician a world-class space to create without barriers.</p>
        <p>Our acoustically tuned rooms are fully equipped and available around the clock, built to handle everything from solo practice to full-band productions.</p>
        <p>We have two Rooms that is 
        </br>
        </br>
        <span>Music Room 1 </span>   in this space we do editing that is both video and audio as well as a recording space for podcast and currently the home of Watumishi podcast
        </br>
        </br>
        <span>Music Room 2 </span>  This is the main rehearsal space and here you will find everything that you need for your session
        </p>
      </div>

      <!-- Right: house rules -->
      <div class="sg-rules">

        <div class="sg-rule danger">
          <i class="ti ti-receipt-off" aria-hidden="true"></i>
          <div>
            <p class="sg-rule-title">No last-minute refunds</p>
            <p class="sg-rule-body">Cancellations made <strong>less than 24 hours</strong> before your session are <strong>non-refundable</strong>. Plan ahead — your slot is reserved exclusively for you.</p>
          </div>
        </div>

        <div class="sg-rule warn">
          <i class="ti ti-clock-exclamation" aria-hidden="true"></i>
          <div>
            <p class="sg-rule-title">Time is money — yours too</p>
            <p class="sg-rule-body">Sessions start and end on the dot. Arriving late does not extend your booking. Please <strong>arrive 10 minutes early</strong> to set up and settle in.</p>
          </div>
        </div>

        <div class="sg-rule info">
          <i class="ti ti-calendar-check" aria-hidden="true"></i>
          <div>
            <p class="sg-rule-title">Rescheduling policy</p>
            <p class="sg-rule-body">Need to move your session? Reschedule <strong>at least 24 hours</strong> in advance at no extra charge. Same-day changes are treated as cancellations.</p>
          </div>
        </div>

        <div class="sg-rule success">
          <i class="ti ti-shield-check" aria-hidden="true"></i>
          <div>
            <p class="sg-rule-title">Respect the space</p>
            <p class="sg-rule-body">All equipment must be handled with care. Damage to gear will be <strong>charged to the booking party</strong>. Leave the room as you found it.</p>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>