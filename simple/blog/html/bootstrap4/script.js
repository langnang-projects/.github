(function () {
  let url = "https://raw.gitmirror.com/langnang/storage/master/data/blog.json";
  if (['localhost', '127.0.0.1'].includes(location.host)) { url = '/storage/data/blog.json'; }
  fetch(url).then(res => res.json()).then(res => {
    console.log(`fetch`, res)
  })
})();