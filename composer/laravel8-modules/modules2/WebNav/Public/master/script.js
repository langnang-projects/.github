
(function () {
  'use strict'

  $(`#${$app.module.alias}-meta-item-modal`).on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget),
      modal = $(this)
    const method = button.data('method'),
      mids = (button.data('mids') || '').toString().split('-').filter(v => v),
      hidden = (button.data('hidden') || '').toString().split(',').filter(v => v),
      disabled = (button.data('disabled') || '').toString().split(',').filter(v => v);
    if (!method) return;

    const mid = mids.slice(-1)[0];
    let meta = { id: mid };
    modal.find(`.modal-footer [name=delete-alert]`).addClass('d-none');
    modal.find(`.modal-body input,.modal-body textarea`).prop('disabled', false);
    // modal.find(`.modal-body input:not([type=hidden]),.modal-body textarea:not([type=hidden])`).val('');
    modal.find(`.modal-body input[type=radio],.modal-body input[type=checkbox]`).prop('checked', false);
    console.log(mids, mid, method);
    meta = mids.slice(1).reduce(function (total, val) {
      return total.find(v => v.id == val);
    }, $app.metas);
    switch (method) {
      case "insert":
        meta.parent = mid;
        meta.id = null;
        break;
      case "delete":
        disabled = [...disabled, 'name', 'slug', 'ico', 'description', 'type', 'status', 'parent',];
        modal.find(`.modal-footer [name=delete-alert]`).removeClass('d-none');
        break;
      case "update":
        break;
      case "select":
        break;
      default: break;
    }
    modal.find('.modal-title').text(method.slice(0, 1).toUpperCase() + method.slice(1) + ' Meta');
    modal.find('.modal-body input[name=_target]').val(method + "_meta_item");

    console.log(button, modal, meta);

    ['id', 'name', 'slug', 'ico', 'parent', 'description'].forEach(val => {
      console.log(val, meta[val] || button.data(val))
      modal.find(`.modal-body [name=${val}]`).val(meta[val] || button.data(val));
    });
    ['type', 'status'].forEach(val => {
      console.log(val, meta[val] || button.data(val))
      modal.find(`.modal-body input[name=${val}][value=${meta[val] || button.data(val)}]`).prop('checked', true);
    });

    disabled.forEach(val => {
      modal.find(`.modal-body [name=${val}]`).prop('disabled', true);
    })

    // switch (method) {
    //   case "insert":
    //     modal.find('.modal-title').text('Insert Meta');
    //     if (mid) modal.find('.modal-body input[name=parent]').val(mid);
    //     break;
    //   case "update":
    //     modal.find('.modal-title').text('Update Meta')
    //     if (mid) modal.find('.modal-body input[name=mid]').val(mid);

    //     meta = mids.slice(1).reduce(function (total, val) {
    //       return total.find(v => v.mid == val);
    //     }, $app.metas);
    //     console.log($app.metas, mids, mid, meta);
    //     if (meta) {
    //       ['name', 'slug', 'ico', 'parent'].forEach(val => {
    //         modal.find(`.modal-body input[name=${val}]`).val(meta[val])
    //       });
    //       ['type', 'status'].forEach(val => {
    //         modal.find(`.modal-body input[name=${val}][value=${meta[val]}]`).prop('checked', true);
    //       });
    //       modal.find(`.modal-body textarea[name=description]`).val(meta.description);
    //     }
    //     break;
    //   case "delete":
    //     modal.find('.modal-title').text('Delete Meta');
    //     if (mid) modal.find('.modal-body input[name=mid]').val(mid);
    //     meta = mids.slice(1).reduce(function (total, val) {
    //       return total.find(v => v.mid == val);
    //     }, $app.metas);
    //     console.log($app.metas, mids, mid, meta);
    //     if (meta) {
    //       ['name', 'slug', 'ico', 'parent'].forEach(val => {
    //         modal.find(`.modal-body input[name=${val}]`).val(meta[val]).prop('disabled', true);
    //       });
    //       ['type', 'status'].forEach(val => {
    //         modal.find(`.modal-body input[name=${val}][value=${meta[val]}]`).prop('checked', true);
    //         modal.find(`.modal-body input[name=${val}]`).prop('disabled', true);
    //       });
    //       modal.find(`.modal-body textarea[name=description]`).val(meta.description).prop('disabled', true);
    //     }
    //     modal.find(`.modal-footer [name=delete]`).removeClass('d-none');
    //     break;
    //   default:
    //     break;
    // }
    //   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    //   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    // modal.find('.modal-title').text('New message to ' + recipient)

  });

  $(`#${$app.module.alias}-content-item-modal`).on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget); // Button that triggered the modal
    console.log(button);
    const cids = (button.data('cids') || '').toString().split('-'); // Extract info from data-* attributes
    const mids = (button.data('mids') || '').toString().split('-');
    const cid = cids.slice(-1)[0];
    const modal = $(this);

    const method = button.data('method'); // Extract info from data-* attributes
    console.log(cid, cids, mids, method);

    modal.find(`.modal-footer [name=delete]`).addClass('d-none');

    modal.find(`.modal-body input,.modal-body textarea`).prop('disabled', false);

    if (mids) modal.find('.modal-body input[name=mids]').val(mids.join(','));

    if (method) {
      modal.find('.modal-body input[name=_target]').val(method)
      let meta, content;
      switch (method) {
        case "insert_content_item":
          modal.find('.modal-title').text('Insert Content');
          // if (cid) modal.find('.modal-body input[name=cid]').val(cid);
          break;
        case "update_content_item":
          modal.find('.modal-title').text('Update Content')

          if (cid) modal.find('.modal-body input[name=cid]').val(cid);
          meta = mids.slice(1).reduce(function (total, val) {
            return total.find(v => v.mid == val);
          }, $app.metas);
          console.log($app.metas, mids, meta);
          content = cids.reduce(function (total, val) {
            return total.find(v => v.cid == val);
          }, meta.contents);
          console.log(content);
          if (content) {
            ['title', 'slug', 'ico', 'parent', 'template'].forEach(val => {
              modal.find(`.modal-body input[name=${val}]`).val(content[val])
            });
            ['type', 'status'].forEach(val => {
              modal.find(`.modal-body input[name=${val}][value=${content[val]}]`).prop('checked', true);
            });
            modal.find(`.modal-body textarea[name=description]`).val(content.description);
            modal.find(`.modal-body textarea[name=text]`).val(content.text);
          }
          break;
        case "delete_content_item":
          modal.find('.modal-title').text('Delete Content');
          if (cid) modal.find('.modal-body input[name=cid]').val(cid);
          meta = mids.slice(1).reduce(function (total, val) {
            return total.find(v => v.mid == val);
          }, $app.metas);
          console.log($app.metas, mids, meta);
          content = cids.reduce(function (total, val) {
            return total.find(v => v.cid == val);
          }, meta.contents);
          console.log(content);
          if (content) {
            ['title', 'slug', 'ico', 'parent', 'template'].forEach(val => {
              modal.find(`.modal-body input[name=${val}]`).val(content[val]).prop('disabled', true);
            });
            ['type', 'status'].forEach(val => {
              modal.find(`.modal-body input[name=${val}][value=${content[val]}]`).prop('checked', true);
              modal.find(`.modal-body input[name=${val}]`).prop('disabled', true);
            });
            modal.find(`.modal-body textarea[name=description]`).val(content.description).prop('disabled', true);;
            modal.find(`.modal-body textarea[name=text]`).val(content.text).prop('disabled', true);
          }
          modal.find(`.modal-footer [name=delete]`).removeClass('d-none');
          break;
        default: break;
      }
    }
  });
})()
