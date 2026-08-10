(function ($) {

  function initDiviSlick() {

    $('.divilife-3-col-feature-blurb-slider').each(function () {
      const $slider = $(this);

      // Destroy if already initialized (important for Divi)
      if ($slider.hasClass('slick-initialized')) {
        $slider.slick('unslick');
      }

      const isBuilder = $('body').hasClass('et-fb');

      $slider.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        dots: false,

        // Disable problematic options in builder
        autoplay: !isBuilder,
        autoplaySpeed: 3000,
        centerMode: false,
        fade: false,

        responsive: [
          {
            breakpoint: 980,
            settings: { slidesToShow: 2 }
          },
          {
            breakpoint: 767,
            settings: { slidesToShow: 1 }
          }
        ]
      });
    });
  }

  // Frontend
  $(document).ready(function () {
    initDiviSlick();
  });

})(jQuery);


jQuery(function ($) {

  $(document).ready(function () {

    $("body ul.et_mobile_menu li.menu-item-has-children, body ul.et_mobile_menu  li.page_item_has_children").append('<a href="#" class="mobile-toggle-icon"></a>');

    $('ul.et_mobile_menu li.menu-item-has-children .mobile-toggle-icon, ul.et_mobile_menu li.page_item_has_children .mobile-toggle-icon').click(function (event) {

      event.preventDefault();

      $(this).parent('li').toggleClass('mobile-toggle-open');

      $(this).parent('li').find('ul.children').first().toggleClass('visible');

      $(this).parent('li').find('ul.sub-menu').first().toggleClass('visible');

    });

    iconFINAL = 'P';

    $('body ul.et_mobile_menu li.menu-item-has-children, body ul.et_mobile_menu li.page_item_has_children').attr('data-icon', iconFINAL);

    $('.mobile-toggle-icon').on('mouseover', function () {

      $(this).parent().addClass('active-toggle');

    }).on('mouseout', function () {

      $(this).parent().removeClass('active-toggle');

    })

  });

});

document.addEventListener("DOMContentLoaded", function () {
  const col = document.querySelector(".logo-column");
  if (!col) return;

  const logos = Array.from(col.querySelectorAll(".image-logo"));

  const left = logos.filter((_, i) => i % 2 === 0);
  const right = logos.filter((_, i) => i % 2 === 1);

  function makeTrack(items, direction) {
    const track = document.createElement("div");
    track.className = "logo-track logo-track--" + direction;

    // Original set
    const originalItems = items.map(el => {
      const clone = el.cloneNode(true);
      track.appendChild(clone);
      return clone;
    });

    // Duplicate set
    items.forEach(el => {
      const clone = el.cloneNode(true);
      track.appendChild(clone);
    });

    return { track, originalItems };
  }

  col.innerHTML = "";

  const { track: leftTrack } = makeTrack(left, "down");
  const { track: rightTrack } = makeTrack(right, "up");

  col.appendChild(leftTrack);
  col.appendChild(rightTrack);

  // Wait for images to load so we get real heights
  function setupAnimation(track, direction) {
    const allItems = track.querySelectorAll(".image-logo");
    const half = allItems.length / 2;

    // Measure only the first half's total height including gaps
    let firstHalfHeight = 0;
    for (let i = 0; i < half; i++) {
      firstHalfHeight += allItems[i].offsetHeight;
    }
    // Add gaps between items
    const gap = 16;
    firstHalfHeight += gap * (half - 1);

    // Inject a keyframe dynamically with exact pixel value
    const animName = direction === "down" ? "scrollDownExact" : "scrollUpExact";

    const styleId = "anim-style-" + direction;
    const existing = document.getElementById(styleId);
    if (existing) existing.remove();

    const style = document.createElement("style");
    style.id = styleId;

    if (direction === "down") {
      style.innerHTML = `
                @keyframes scrollDownExact {
                    0%   { transform: translateY(0); }
                    100% { transform: translateY(-${firstHalfHeight + gap}px); }
                }
            `;
      track.style.animation = `scrollDownExact 18s linear infinite`;
    } else {
      style.innerHTML = `
                @keyframes scrollUpExact {
                    0%   { transform: translateY(-${firstHalfHeight + gap}px); }
                    100% { transform: translateY(0); }
                }
            `;
      track.style.animation = `scrollUpExact 18s linear infinite`;
    }

    document.head.appendChild(style);
  }

  // Use requestAnimationFrame + small timeout to ensure images are rendered
  function waitForImages(track, callback) {
    const imgs = track.querySelectorAll("img");
    let loaded = 0;
    const total = imgs.length;

    if (total === 0) { callback(); return; }

    imgs.forEach(img => {
      if (img.complete) {
        loaded++;
        if (loaded === total) callback();
      } else {
        img.addEventListener("load", () => { loaded++; if (loaded === total) callback(); });
        img.addEventListener("error", () => { loaded++; if (loaded === total) callback(); });
      }
    });
  }

  waitForImages(leftTrack, () => setupAnimation(leftTrack, "down"));
  waitForImages(rightTrack, () => setupAnimation(rightTrack, "up"));
});