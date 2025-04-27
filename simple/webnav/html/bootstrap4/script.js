/* globals Chart:false, feather:false */

(function () {
  'use strict'
  feather.replace()
})();
function imgLoadError(element) {
  // console.log(`imgLoadError`, element)
  $(element).addClass('d-none');
  $(element).next().removeClass('d-none');
}
(function () {
  let url = "https://raw.gitmirror.com/langnang/storage/master/data/webnav.json";
  if (['localhost', '127.0.0.1'].includes(location.host)) { url = '/storage/data/webnav.json'; }
  fetch(url).then(res => res.json()).then(res => {
    console.log(`fetch`, res);
    const { contents } = res;

    let html = `<div class="row">`, warning_contents = [];
    Object.values(contents).forEach(v => {
      if (!v.title || v.status === 'private' || v.visible == false) {
        warning_contents.push(v);
        return;
      };
      if (typeof v.icon !== 'string') v.icon = v.icon[0];
      if (v.icon.substr(0, 4) !== 'http') v.icon = v.slug + v.icon;
      html +=
        `<div class="col-md-4 px-2">
            <div class="card my-2 shadow" data-toggle="tooltip" data-placement="bottom" title="${v.slug}" onclick="window.open('${v.slug}', '_blank')">
              <div class="card-body p-3">
                <div class="media">
                  <img data-src="${v.icon}" class="lozad rounded mr-2" width="48" height="48" alt="..." onerror="imgLoadError(this)">
                  <svg class="rounded mr-2 d-none" width="48" height="48" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#55595c" />
                  </svg>
                  <div class="media-body overflow-hidden">
                    <h6 class="mt-0 text-nowrap text-truncate">${v.title}</h6>
                    <p class="small mb-0 overflow-hidden" style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;  height: 2.5rem;  text-overflow: ellipsis;  ">${v.description}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          `
    })
    html += '</div>';
    console.log(warning_contents);
    $('[role=main]').html(html);
    $('[data-toggle="tooltip"]').tooltip()
    //img lazy loaded
    const observer = lozad();
    observer.observe();
  })
})();