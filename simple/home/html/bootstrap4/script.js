(function () {
  "use strict";

  fetch("/storage/data/main.json")
    .then(res => res.json())
    .then(res => {
      const html = Object.values(res.contents).reduce((t, v) => {
        return t + (v.title && v.status !== 'private' ? `<a class="btn btn-sm btn-secondary my-1 pl-1 ${v._url && v._url[location.origin] ? '' : 'disabled'}" href="${v._url && v._url[location.origin] ? v._url[location.origin] : '#'}" role="button" aria-pressed="true"><span class="dot mr-1"></span>${v.title + (v.titleCn ? ' - ' + v.titleCn : '')}</a>\t` : '');
      }, ``)
      $("[role='main-site-group']").html(html);
    })

})();