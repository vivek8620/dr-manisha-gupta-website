<section class="relative bg-gradient-to-b from-[#f8fdff] via-white to-[#f0f9ff] py-8 sm:py-10 lg:py-14 overflow-hidden">

  <!-- Background Blur -->
  <div class="absolute top-0 left-0 w-64 h-64 bg-sky-100/40 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
  <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

    <!-- Heading -->
    <div class="text-center mb-10 px-4">
      <h2 class="section-heading text-4xl md:text-6xl font-semibold leading-tight font-fraunces tracking-tight">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#58A9E2] to-[#064854]">
          Specialities
        </span>
      </h2>
      <div class="w-20 h-1.5 bg-gradient-to-r from-[#74C2F9] to-[#064854] mx-auto mt-5 rounded-full"></div>
    </div>

    <!-- Cards Grid -->
    <div id="specialities-grid"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6 items-stretch">

      <?php

      $specialities = [

        [
          "title" => "Cardiology Care",
          "short" => "Heart health management & preventive care.",
          "desc"  => "Evaluation of heart-related conditions including hypertension, coronary artery disease, and preventive cardiac care.",
          "icon"  => "fa-heart-pulse",
          "color" => "from-red-500 to-pink-500"
        ],

        [
          "title" => "Diabetology",
          "short" => "Smart diabetes care & sugar control.",
          "desc"  => "Personalized plans designed to control blood sugar, prevent complications, and improve overall lifestyle.",
          "icon"  => "fa-brands fa-accessible-icon",
          "color" => "from-blue-500 to-sky-500"
        ],

        [
          "title" => "Gastro Care",
          "short" => "Digestive health & gastric care.",
          "desc"  => "Expert diagnosis of acidity, IBS, acid reflux, and liver-related issues for better digestive health.",
          "icon"  => "images/icons/stomach_5592430.png",
          "color" => "from-teal-500 to-green-500"
        ],

        [
          "title" => "Thyroid Care",
          "short" => "Hormonal balance & thyroid management.",
          "desc"  => "Holistic care for hypothyroidism and hyperthyroidism with focus on medication balance and stability.",
          "icon"  => "images/icons/thyroid_7592416.png",
          "color" => "from-purple-500 to-indigo-500"
        ],

        [
          "title" => "Fever and Infections",
          "short" => "Acute, chronic & undiagnosed fever care.",
          "desc"  => "Investigations and management of acute seasonal fever and infections, along with undiagnosed long-standing or recurrent fever.",
          "icon"  => "fa-temperature-full",
          "color" => "from-red-500 to-orange-500"
        ],

        [
          "title" => "Vaccination",
          "short" => "Complete adult vaccination care.",
          "desc"  => "Prescription of all vaccine-preventable diseases in adults, ensuring timely and complete immunization coverage.",
          "icon"  => "fa-syringe",
          "color" => "from-teal-500 to-cyan-500"
        ]

      ];

      foreach ($specialities as $index => $spec):
      ?>

        <!-- CARD -->
        <div class="group relative h-[300px] sm:h-[320px] cursor-pointer">

          <!-- FRONT CARD -->
          <div class="front-card absolute inset-0 bg-white rounded-[28px] sm:rounded-[32px]
            border border-[#0A2F45]
            p-6 sm:p-8
            flex flex-col
            overflow-hidden
            shadow-[0_10px_40px_-15px_rgba(0,0,0,0.08)]
            transition-all duration-300 ease-out">

            <!-- Corner Accent -->
            <div class="corner-accent absolute top-0 right-0 w-24 h-24 bg-gradient-to-br <?= $spec['color'] ?>
          opacity-[0.06] rounded-bl-full transition-all duration-300"></div>

            <!-- TOP CONTENT -->
            <div class="flex-1">

              <!-- Icon -->
              <div class="icon-box w-16 h-16 rounded-2xl bg-gradient-to-br <?= $spec['color'] ?>
                p-[1px] mb-7 transition-transform duration-300 ease-out">

                <div class="icon-inner w-full h-full bg-white rounded-[14px]
                    flex items-center justify-center
                    text-2xl text-gray-800
                    transition-all duration-300">

                  <?php if (str_contains($spec['icon'], 'fa-')): ?>

                    <i class="fa-solid <?= $spec['icon'] ?>"></i>

                  <?php else: ?>

                    <img
                      src="<?= $spec['icon'] ?>"
                      alt="<?= $spec['title'] ?>"
                      width="512"
                      height="512"
                      loading="lazy"
                      decoding="async"
                      class="icon-image w-8 h-8 object-contain transition-all duration-300">

                  <?php endif; ?>

                </div>

              </div>

              <!-- Title -->
              <h3 class="text-[22px] font-bold text-[#042A3F] mb-4 leading-tight">
                <?= $spec['title'] ?>
              </h3>

              <!-- Short Text -->
              <p class="text-gray-500 text-sm leading-relaxed max-w-[220px]">
                <?= $spec['short'] ?>
              </p>

            </div>

            <!-- Learn More -->
            <button type="button"
              class="learn-more-btn pt-4 flex items-center text-sky-600 font-bold text-xs uppercase tracking-[2px] transition-all duration-300">

              Learn More

              <i class="fa-solid fa-arrow-right ml-2 text-[11px]"></i>

            </button>

          </div>

          <!-- ================= BACK CARD ================= -->
          <div class="spec-back absolute inset-0 bg-[#042A3F]
            rounded-[28px] sm:rounded-[32px]
            border border-[#0A2F45]
            p-7 sm:p-8
            translate-y-full opacity-0
            transition-all duration-500 ease-out
            z-20
            flex flex-col justify-center
            overflow-hidden">

            <!-- Glow -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br <?= $spec['color'] ?>
            opacity-10 rounded-bl-full blur-2xl pointer-events-none"></div>

            <!-- Number -->
            <div class="text-white/10 text-6xl sm:text-7xl font-black italic select-none mb-3 leading-none">
              0<?= $index + 1 ?>
            </div>

            <!-- Title -->
            <h3 class="text-white text-2xl font-bold mb-4 relative z-10 leading-tight">
              <?= $spec['title'] ?>
            </h3>

            <!-- Description -->
            <p class="text-white/75 text-[13.5px] leading-relaxed mb-7 relative z-10">
              <?= $spec['desc'] ?>
            </p>

            <div class="w-14 h-1.5 bg-[#00A3E1] rounded-full relative z-10"></div>

          </div>

        </div>

      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ========================= DESKTOP HOVER ========================= -->
<style>
  @media (min-width: 1024px) {

    /* #specialities-grid .group:hover .front-card {
      transform: scale(0.97);
      box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.15);
    }

    #specialities-grid .group:hover .icon-box {
      transform: rotate(6deg) scale(1.1);
    }

    #specialities-grid .group:hover .icon-inner {
      background: transparent;
      color: white;
    }

    #specialities-grid .group:hover .icon-image {
      filter: brightness(0) invert(1);
    }

    #specialities-grid .group:hover .corner-accent {
      opacity: 0.1;
    }

    #specialities-grid .group:hover .learn-more-btn {
      transform: translateX(8px);
      color: #0ea5e9;
    }

    #specialities-grid .group:hover .spec-back {
      transform: translateY(0);
      opacity: 1;
    } */

    #specialities-grid .group {
      position: relative;
    }

    #specialities-grid .front-card,
    #specialities-grid .spec-back {
      pointer-events: none;
    }

    #specialities-grid .group:hover .front-card {
      transform: scale(.97);
      box-shadow: 0 20px 50px -10px rgba(0, 0, 0, .15);
    }

    #specialities-grid .group:hover .icon-box {
      transform: rotate(6deg) scale(1.1);
    }

    #specialities-grid .group:hover .icon-inner {
      background: transparent;
      color: #fff;
    }

    #specialities-grid .group:hover .icon-image {
      filter: brightness(0) invert(1);
    }

    #specialities-grid .group:hover .corner-accent {
      opacity: .1;
    }

    #specialities-grid .group:hover .learn-more-btn {
      transform: translateX(8px);
      color: #0ea5e9;
    }

    #specialities-grid .group:hover .spec-back {
      transform: translateY(0);
      opacity: 1;
    }

  }

  /* MOBILE */
  @media (max-width: 1023px) {

    #specialities-grid .group {
      transform: translateZ(0);
      backface-visibility: hidden;
    }

    #specialities-grid .spec-back {
      will-change: transform, opacity;
    }

  }
</style>

<!-- ========================= MOBILE CLICK FUNCTION ========================= -->
<script>
  (function() {

    // Mobile & Tablet only
    if (window.innerWidth >= 1024) return;

    const cards = document.querySelectorAll('#specialities-grid .group');

    cards.forEach(function(card) {

      // Card Click
      card.addEventListener('click', function() {

        const isOpen = card.classList.contains('is-hovered');

        // Close all
        cards.forEach(function(c) {
          c.classList.remove('is-hovered');
        });

        // Open clicked
        if (!isOpen) {
          card.classList.add('is-hovered');
        }

      });

      // Learn More Click
      const btn = card.querySelector('.learn-more-btn');

      if (btn) {

        btn.addEventListener('click', function(e) {

          e.stopPropagation();

          const isOpen = card.classList.contains('is-hovered');

          cards.forEach(function(c) {
            c.classList.remove('is-hovered');
          });

          if (!isOpen) {
            card.classList.add('is-hovered');
          }

        });

      }

    });

    // Outside Click Close
    document.addEventListener('click', function(e) {

      if (!e.target.closest('#specialities-grid .group')) {

        cards.forEach(function(c) {
          c.classList.remove('is-hovered');
        });

      }

    });

  })();
</script>

<!-- ========================= MOBILE ACTIVE STATES ========================= -->
<style>
  #specialities-grid .group.is-hovered .spec-back {
    transform: translateY(0);
    opacity: 1;
  }

  #specialities-grid .group.is-hovered .front-card {
    transform: scale(0.97);
    box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.15);
  }

  #specialities-grid .group.is-hovered .icon-box {
    transform: rotate(6deg) scale(1.1);
  }

  #specialities-grid .group.is-hovered .icon-inner {
    background: transparent;
    color: white;
  }

  #specialities-grid .group.is-hovered .icon-image {
    filter: brightness(0) invert(1);
  }

  #specialities-grid .group.is-hovered .corner-accent {
    opacity: 0.1;
  }

  #specialities-grid .group.is-hovered .learn-more-btn {
    transform: translateX(8px);
    color: #0ea5e9;
  }
</style>