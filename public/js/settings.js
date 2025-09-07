$('#repeater1').repeater({
  initEmpty: false,
  defaultValues: { 'contentSeekers': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});

$('#repeater2').repeater({
  initEmpty: false,
  defaultValues: { 'contentFreelanceAndBusiness': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});

$('#repeater3').repeater({
  initEmpty: false,
  defaultValues: { 'contentKeyFeatures': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});


$('#repeater4').repeater({
  initEmpty: false,
  defaultValues: { 'contentUserResponsibilities': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});


$('#repeater5').repeater({
  initEmpty: false,
  defaultValues: { 'contentCompanyResponsibilities': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});

$('#repeater6').repeater({
  initEmpty: false,
  defaultValues: { 'contentCustomSuggestions': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});

$('#repeater7').repeater({
  initEmpty: false,
  defaultValues: { 'contentYourRights': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});

$('#repeater8').repeater({
  initEmpty: false,
  defaultValues: { 'contentInformationCollect': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});


$('#repeater9').repeater({
  initEmpty: false,
  defaultValues: { 'contentWhyAdvertiseWithUs': '' },
  show: function () { $(this).slideDown(); },
  hide: function (deleteElement) { $(this).slideUp(deleteElement); }
});


// alert(document.documentElement.lang);
// Initialize Quill editor
var toolbarOptions = [
  ['bold', 'italic', 'underline'], // toggled buttons 

  // [{ 'size': ['14px', '16px', '18px'] }],
  [{
    'list': 'ordered'
  }, {
    'list': 'bullet'
  }],
  [{
    'header': [1, 2, 3, 4, 5, 6, false]
  }],
  [{
    'color': []
  }, {
    'background': []
  }], // dropdown with defaults from theme
  ['clean'] // remove formatting button
];
var quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});


if (document.documentElement.lang == 'ar') {
  quill.format('direction', 'rtl');
  quill.format('align', 'right');
} else {
  quill.format('direction', 'ltr');
  quill.format('align', 'left');
}
// quill.on('text-change', function() {
//     $('#TextAreaUsageTerms').val($('#editor .ql-editor').html());
// });

function submitFormUsageTerm() {
  $('#TextAreaUsageTerms').val($('#editor .ql-editor').html());
  $('#formUsageTermPage').submit();
}

function submitformPrivacyPage() {
  $('#TextAreaPrivacy').val($('#editor .ql-editor').html());
  $('#formPrivacyPage').submit();
}

function submitFormAbout() {
  $('#TextAreaAbout').val($('#editor .ql-editor').html());
  $('#formAbout').submit();
}

function submitformOurVision() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextOurVision').val($('#editor .ql-editor').html());
  $('#formOurVision').submit();
}


function submitformPlatformUsage() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextPlatormUsage').val($('#editor .ql-editor').html());
  $('#formPlatformUsage').submit();
}


function submitAccountSuspensionPolicy() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextAccountSuspensionPolicy').val($('#editor .ql-editor').html());
  $('#formAccountSuspensionPolicy').submit();
}

function submitHelpShapeAnceega() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextHelpShapeAnceega').val($('#editor .ql-editor').html());
  $('#formHelpShapeAnceega').submit();
}


function submitHowUseData() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextHowUseData').val($('#editor .ql-editor').html());
  $('#formHowUseData').submit();
}


function submitHelpAndSupport() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextHelpAndSupport').val($('#editor .ql-editor').html());
  $('#formHelpAndSupport').submit();
}

function submitAdvertiseAnceega() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextAdvertiseAnceega').val($('#editor .ql-editor').html());
  $('#formAdvertiseAnceega').submit();
}

function submitAdvertiseForCompanies() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextAdvertiseForCompanies').val($('#editor .ql-editor').html());
  // $('#videoAdvertiseForCompanies').val();
  $('#formAdvertiseForCompanies').submit();
}


function submitAdvertiseForUsers() {
  // alert( $('#TextOurVision').val($('#editor .ql-editor').html())) ; 
  $('#TextAdvertiseForUsers').val($('#editor .ql-editor').html());
  $('#formAdvertiseForUsers').submit();
}