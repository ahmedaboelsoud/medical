import app from '../app.js';

export const showToastr = (type, message) => {
  app.$bvToast.toast(message, {
    variant: type,
    toastClass: ['toaster-custom'],
  })
}

export const showSwal = (type, text, title = '') => {
  app.$swal.fire({
    title,
    text,
    icon: type,
    confirmButtonText: "إغلاق",
  })
}

export const showFieldErrors = (errors) => {
  Object.keys(errors).forEach((key) => {
    var eleName = key;

    let ele = $(`[name="${eleName}"]`);
    ele.addClass("is-invalid");

    if (ele.hasClass("select2")) {
      ele.parent().find(".select2-selection").addClass("is-invalid");
    }

    // add error message
    if (ele.closest(".input-group").length) {
      ele.closest(".input-group")
        .append(
          `<div class="invalid-feedback">${errors[key][0]}</div>`
        );
    } else if (ele.closest('div[class^="col-"').length) {
      ele.closest('div[class^="col-"')
        .append(
          `<div class="invalid-feedback">${errors[key][0]}</div>`
        );
    }
  });
}

export const removeFieldsErrors = (fieldName = null) => {
  if (fieldName) {
    $(`[name="${fieldName}"]`).removeClass('is-invalid');
    $(`[name="${fieldName}"]`).closest('.input-group').find('.invalid-feedback').remove();
    $(`[name="${fieldName}"]`).closest('div[class^="col-"').find('.invalid-feedback').remove();
  } else {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
  }
}