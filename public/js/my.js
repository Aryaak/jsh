// Useful Variable
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    showCloseButton: true,
    timer: 5000,
    showClass: {
        popup: "animate__bounceIn"
    },
    hideClass: {
        popup: "animate__bounceOut"
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const Confirm = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success btn-icon-text',
        cancelButton: 'btn btn-info btn-icon-text me-2',
        title: 'confirm-title',
        popup: 'confirm-toast'
    },
    buttonsStyling: false,
    reverseButtons: true,
    showCancelButton: true,
    icon: 'question',
    confirmButtonText: "<i class='fa-solid fa-check me-2'></i>Ya",
    cancelButtonText: "<i class='fa-solid fa-close me-2'></i>Tidak"
})

const NegativeConfirm = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-danger btn-icon-text',
        cancelButton: 'btn btn-info btn-icon-text me-2',
    },
    buttonsStyling: false,
    reverseButtons: true,
    showCancelButton: true,
    icon: 'warning',
    confirmButtonText: "<i class='fa-solid fa-check me-2'></i>Ya",
    cancelButtonText: "<i class='fa-solid fa-close me-2'></i>Tidak"
})

const DenyConfirm = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success btn-icon-text',
        denyButton: 'btn btn-danger btn-icon-text me-2',
        title: 'confirm-title',
        popup: 'confirm-toast'
    },
    buttonsStyling: false,
    reverseButtons: true,
    showCancelButton: false,
    showDenyButton: true,
    icon: 'question',
    confirmButtonText: "<i class='fa-solid fa-check btn-icon-text me-2'></i>Ya",
    cancelButtonText: "<i class='fa-solid fa-close btn-icon-text me-2'></i>Tidak"
})

const ToRupiah = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
});

const ToUnit = new Intl.NumberFormat('id-ID', {
    style: 'decimal',
    minimumFractionDigits: 0,
    maximumFractionDigits: 1
});

const ChartOptionToRupiah = {
    plugins: {
        tooltip: {
            callbacks: {
                label: function(context) {
                    var label = context.dataset.label || '';

                    if (label) {
                        label += ': ';
                    }

                    if (context.parsed.y !== null) {
                        label += (ToRupiah.format(context.parsed.y)).replaceAll('\u00A0', '') + ',-'
                    }

                    return label;
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function(value, index, values) {
                    let nominal = (ToRupiah.format(value)).replaceAll('\u00A0', '') + ',-'
                    return nominal
                }
            }
        },
    }
}

const ChartOptionToKg = {
    plugins: {
        tooltip: {
            callbacks: {
                label: function(context) {
                    var label = context.dataset.label || '';

                    if (label) {
                        label += ': ';
                    }

                    if (context.parsed.y !== null) {
                        label += ToUnit.format(context.parsed.y) + ' kg'
                    }

                    return label;
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function(value, index, values) {
                    let nominal = ToUnit.format(value) + ' kg'
                    return nominal
                }
            }
        },
    }
}

// Useful Function

function loading() {
    Swal.fire({
        html: "<div class='display-1'><i class='fa-solid fa-spin fa-circle-notch' style='color: #fff'></i></div>",
        background: 'rgba(255, 255, 255, 0)',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
    });
}

function loadingWithText(text) {
    Swal.fire({
        html: "<div class='mb-10'><i class='display-1 fa-solid fa-spin fa-circle-notch'></i></div>" + text,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
    });
}

function debounce(func, wait = 1000, immediate = false) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function removeAllIsInvalid(formselector) {
    $(formselector).find('.is-invalid').each(function () {
        $(this).removeClass('is-invalid')
    })
}

function ajaxErrorResponse(request, status, error) {
    let title = "Terjadi masalah pada server!!"
    let msg = "- Harap muat ulang halaman dan coba lagi<br>- Jika masalah terus terjadi harap hubungi penyedia layanan anda!"
    let icon = 'error'
    if (request.status==422) {
        title = "Data kurang lengkap!"
        let validation_error_msg="";
        Object.keys(request.responseJSON.errors).forEach(key => {
            validation_error_msg += "- "+request.responseJSON.errors[key]+"<br>"
        });
        msg = validation_error_msg
        icon = 'warning'
    }
    Toast.fire({
        icon: icon,
        title: title,
        html: msg,
        width: '38%',
    })
}

function ajaxPost(url, data, modal = null, successCallback = null, errorCallback = null, withToast = true) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function(result) {
            if (modal != null) {
                $(modal).modal('hide')
            }

            if (typeof successCallback == 'function') successCallback(result)

            if (withToast) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })
            }
        },
        error: function (request, status, error) {
            if (withToast) {
                ajaxErrorResponse(request, status, error)
            }
            if (typeof errorCallback == 'function') errorCallback(request.responseJSON)
        }
    })
}

function ajaxGet(url, modal = null, successCallback = null, errorCallback = null, successToast = false, errorToast = true) {
    loading()

    $.ajax({
        type: "GET",
        url: url,
        cache: true,
        success: function(result) {
            let icon = 'success';
            if (typeof successCallback == 'function') successCallback(result)

            Swal.close();

            if (successToast) {
                Toast.fire({
                    icon: icon,
                    title: result.message
                })
            }
        },
        error: function (request, status, error) {
            if (errorToast) {
                ajaxErrorResponse(request, status, error)
            }

            if (modal != null) {
                $(modal).modal('hide')
            }

            console.log(error);
            if (typeof errorCallback == 'function') errorCallback(error)
        },
    })
}

function clearForm(formselector) {
    $(formselector).find('input').each(function () {
        if ($(this).attr('name') !== '_method' && $(this).attr('name') !== '_token' &&
            $(this).attr('type') !== 'checkbox' && $(this).attr('type') !== 'radio') {
            $(this).val('')
        }
    })
    $(formselector).find('textarea').each(function () {
        $(this).val('')
    })
    $(formselector).find('select').each(function () {
        $(this).val('').trigger('change')
    })
}

function numberFormat(number, decimals = 0, thousand_separator = '.', decimal_separator = ',') {
    number += '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? decimal_separator + x[1].substring(0, decimals) : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + thousand_separator + '$2');
    }
    return x1 + x2;
}

function datatablesTranslate(attr = 'Data', verb = 'ditambahkan') {
    return {
        "lengthMenu": "Menampilkan _MENU_ " + attr.toLowerCase() + " per halaman",
        "emptyTable": "Masih belum ada " + attr.toLowerCase() + " yang " + verb + ".",
        "zeroRecords": attr + " yang dicari tidak ditemukan.",
        "info": "Halaman _PAGE_ dari _PAGES_ (menampilkan _START_ sampai _END_ dari _TOTAL_ " + attr.toLowerCase() + ")",
        "infoEmpty": "Tidak ada " + attr.toLowerCase() + ".",
        "infoFiltered": "(disaring dari total _MAX_ " + attr.toLowerCase() + ")",
        "loadingRecords": "Sedang memuat ...",
        "processing": "Sedang memproses ...",
        "search": "Cari:",
        "thousands": ".",
        "paginate": {
            "next": ">",
            "previous": "<"
        },
    }
}
function dataTableInit(id,title,ajax,column,properties = {},translate = null,button = false,action = true){
    let buttons = []
    let dom = "<'row'<'col'l><'col'f>>rt<'row'<'col'i><'col mt-1'p>>"
    if(button){
      dom = "<'row'<'col'l><'col'f><'col-1 text-center'B>>rt<'row'<'col'i><'col mt-1'p>>"
      buttons = [
        {
          extend: 'excelHtml5',
          title: title,
          className: 'btn-sm btn-outline-secondary',
          exportOptions: {
            columns: ':not(:last-child)',
          }
        },
        {
          extend: 'pdfHtml5',
          title: title,
          className: 'btn-sm btn-outline-secondary',
          exportOptions: {
            columns: ':not(:last-child)',
          },
          customize: function(doc) {
            doc.content[1].margin = [ 100, 0, 100, 0 ] //left, top, right, bottom
          }
        }
      ]
    }
    let columns = [{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,width: '1%' }]
    column.forEach(e => { columns = columns.concat(e) })
    if(action){ columns = columns.concat([{ data: 'action', name: 'action', orderable: false, searchable: false,className: 'text-center' }]) }

    let initParams = {
      dom: dom,
      buttons: buttons,
      processing: true,
      serverSide: true,
      scrollCollapse: true,
      pageLength : 10,
      order: [[0,'asc']],
      lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
      pagingType: 'full_numbers',
      ajax: ajax,
      columns: columns,
      language: translate ?? datatablesTranslate(title),
    }
    Object.keys(properties).forEach(key => { initParams[key] = properties[key] });
    return $('#'+id).DataTable(initParams);
}

// function datatablesInit(selector, url, columns, orders = [1, 'asc'], translate, drawCallback = null, data = {}, withAction = true, withCheck = true, createdRow = null) {
//     if (withCheck) {
//         var column = [
//             { data: 'check', orderable: false, searchable: false, className: "text-center"},
//             { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
//         ]
//     }
//     else {
//         var column = [{ data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"}]
//     }

//     columns.forEach(row => {
//         column.push(row)
//     });

//     if (withAction) {
//         column.push({ data: 'action', orderable: false, searchable: false, className: "text-center"})
//     }

//     return $(selector).DataTable({
//         dom: '<"table-responsive w-100"rt><"d-flex flex-column flex-lg-row justify-content-between align-items-center"ip>',
//         processing: true,
//         serverSide: true,
//         ajax: {
//             'url' : url,
//             'data' : data
//         },
//         order: [
//             orders
//         ],
//         columns: column,
//         language: translate,
//         drawCallback: function(e) {
//             $('[data-bs-toggle="tooltip"]').tooltip()
//             $('.table-check').each(function(index) {
//                 if ($.inArray($(this).val(), tableCheck) != -1) {
//                     $(this).prop('checked', true)
//                 }
//                 else {
//                     $(this).prop('checked', false)
//                 }
//             });

//             $(selector + '-export-length').val(e.json.input.length)
//             $(selector + '-export-start').val(e.json.input.start)

//             if (typeof drawCallback == 'function') drawCallback()
//         },
//         createdRow: function (row, data, index) {
//             if (typeof createdRow == 'function') createdRow(row, data, index)
//         }
//     })
// }

function dropzoneTranslate(attr = 'Berkas') {
    return {
        dictDefaultMessage: "Jatuhkan " + attr.toLowerCase() + " ke sini untuk mengunggah.",
        dictFallbackMessage: "Browser Anda tidak mendukung 'drag and drop' berkas.",
        dictFallbackText: "Silakan gunakan cara lama untuk mengunggah berkas.",
        dictFileTooBig: "Ukuran berkas terlalu besar ({{filesize}}MB). Ukuran maksimum: {{maxFilesize}}MB.",
        dictInvalidFileType: "Ekstensi berkas tidak sesuai.",
        dictResponseError: "Terjadi masalah pada sistem, silakan hubungi penyedia layanan Anda! Kode: {{statusCode}}.",
        dictCancelUpload: "Batal unggah",
        dictUploadCanceled: "Pengunggahan dibatalkan.",
        dictCancelUploadConfirmation: "Yakin ingin membatalkan unggahan ini?",
        dictRemoveFile: "Hapus " + attr.toLowerCase(),
        dictRemoveFileConfirmation: "Yakin ingin menghapus " + attr.toLowerCase() + " ini?",
        dictMaxFilesExceeded: "Total " + attr.toLowerCase + " yang diunggah sudah mencapai batas.",
    }
}

function dropzoneInit(selector, formSelector, url, token, formName, maxFiles = 1, acceptedFiles = "image/*", translate = null, successCallback = null, removedfileCallback = null){
    if (translate == null) translate = dropzoneTranslate()

    return new Dropzone(selector, {
        dictDefaultMessage: translate.dictDefaultMessage,
        dictFallbackMessage: translate.dictFallbackMessage,
        dictFallbackText: translate.dictFallbackText,
        dictFileTooBig: translate.dictFileTooBig,
        dictInvalidFileType: translate.dictInvalidFileType,
        dictResponseError: translate.dictResponseError,
        dictCancelUpload: translate.dictCancelUpload,
        dictUploadCanceled: translate.dictUploadCanceled,
        dictCancelUploadConfirmation: translate.dictCancelUploadConfirmation,
        dictRemoveFile: translate.dictRemoveFile,
        dictRemoveFileConfirmation: translate.dictRemoveFileConfirmation,
        dictMaxFilesExceeded: translate.dictMaxFilesExceeded,

        url: url,
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        maxFiles: maxFiles,
        acceptedFiles: acceptedFiles, // ".jpeg,.jpg,.png,.gif", Accepted File Formats for Uploads https://onlinecode.org/dropzone-allowed-file-extensions-tutorials-technology/
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function (file, response) {
            $(formSelector).append('<input type="hidden" name="' + formName + '[]" value="' + file.name + '">')
            if (typeof successCallback == 'function') successCallback(file, response)
        },
        removedfile: function (file) {
            file.previewElement.remove()
            $(formSelector).find('input[name="' + formName + '[]"][value="' + file.name + '"]').remove()

            let data = new FormData()
            data.append('_token', token)
            data.append('file_name', file.name)
            data.append('is_removing', true)

            ajaxPost(url, data, null, null, null, false)

            if (typeof removedfileCallback == 'function') removedfileCallback(file)

            var file_count = $("input[name='"+formName+"[]']").map(function(){return $(this).val();}).get().length;
            if(file_count < this.options.maxFiles) $(".dz-hidden-input").prop("disabled",false);
        },
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }
    });
}

function dropzonePreview(dz, images, url, formSelector, formName){
    dz.element.classList.remove("dz-started");
    $(formSelector).find("input[name='"+formName+"[]']").remove()
    $(".dz-hidden-input").prop("disabled", false);

    $('.dz-preview').remove()
    dz.removeAllFiles(true)
    if(images){
        images.forEach(image => {
            let mockFile = { name: image.name, size: image.size};
            dz.displayExistingFile(mockFile, url + "/" + mockFile.name);
            $(formSelector).append('<input type="hidden" name="'+ formName +'[]" value="' + mockFile.name + '">')

            var file_count = $("input[name='"+formName+"[]']").map(function(){return $(this).val();}).get().length;
            if(file_count >= dz.options.maxFiles) $(".dz-hidden-input").prop("disabled", true);
        });
    }
}

function select2Init(selector, url, minLength = 1, placeholder = "--  Pilih --", allowClear = false) {
    $(selector).select2({
        language: {
            errorLoading: function() { return "Terjadi masalah pada sistem." },
            inputTooLong: function(n) { return "Hapus " + (n.input.length - n.maximum) + " huruf"},
            inputTooShort: function(n) { return "Masukkan " + (n.minimum - n.input.length) + " huruf lagi untuk mencari"},
            loadingMore: function() { return "Mengambil data ..." },
            maximumSelected: function(n) { return "Anda hanya dapat memilih " + n.maximum + " pilihan"},
            noResults: function() { return "Tidak ada data yang sesuai" },
            searching: function() { return "Mencari ..." },
            removeAllItems: function() { return "Hapus semua pilihan" }
        },
        allowClear: allowClear,
        minimumInputLength: minLength,
        ajax: {
            url: url,
            type: 'get',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                }
            },
            processResults: function(response) {
                return {
                    results: response
                }
            },
            cache: true,
        }
    })

    let cleanSelector = selector.replace('#', '').replace('.', '')
    $("#select2-" + cleanSelector + "-container").html(placeholder)
    $("#select2-" + cleanSelector + "-container").attr('title', placeholder)

    $(selector).on('select2:clearing', function (e) {
        setTimeout(function() {
            $("#select2-" + cleanSelector + "-container").html(placeholder)
            $("#select2-" + cleanSelector + "-container").attr('title', placeholder)
        }, 1)
    });
}

function sortableInit(zoneSelector = '.draggable-zone', draggableSelector = '.draggable', draggableHandleSelector = '.draggable-handle', mirrorAppendSelector = 'body', constrainDimensions = true) {
    var containers = document.querySelectorAll(zoneSelector);

    if (containers.length === 0) {
        return false;
    }

    var swappable = new Sortable.default(containers, {
        draggable: draggableSelector,
        handle: draggableHandleSelector,
        mirror: {
            appendTo: mirrorAppendSelector,
            constrainDimensions: constrainDimensions
        },
    });

    return swappable
}

function tinyMCEImageUploadHandler(url, token) {
    return (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', url);
        xhr.setRequestHeader('X-CSRF-TOKEN', token);

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }

            const json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }

            resolve(json.location);
        };

        xhr.onerror = () => {
          reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    });
}

function dateRangePickerTranslate() {
    return {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Terapkan",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Hingga",
        "customRangeLabel": "Atur Sendiri",
        "weekLabel": "M",
        "daysOfWeek": [
            "M",
            "S",
            "S",
            "R",
            "K",
            "J",
            "S"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
    }
}

function copyToClipboard(targetSelector, alert = null) {
    const target = document.getElementById(targetSelector)
    target.select()
    target.setSelectionRange(0, 99999)
    navigator.clipboard.writeText(target.value)
    if (alert != null) {
        Toast.fire({
            icon: 'success',
            title: alert,
        })
    }
}

// Useful functionality by giving class to the element

$(document).ready(function (e) {
    $(document).on('keyup input', '.to-rupiah', function (e) {
        const allowedKey = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
        const input = $(this)
        var lastCharacter = input.val().substr(input.val().length - 1) ?? 0;

        if (input.val() != '') {
            while (!$.isNumeric(lastCharacter) && input.val() != '') {
                input.val(input.val().slice(0, -1))
                lastCharacter = input.val().substr(input.val().length - 1);
            }
        }

        if($.inArray(lastCharacter, allowedKey) !== -1) {
            input.val(ToRupiah.format(input.val().replaceAll('.', '')).replace('Rp\u00A0', ''))
        }

        if (input.val() == '') {
            input.val(0)
        }
    })

    $(document).on('keyup input', '.to-unit', function (e) {
        const allowedKey = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
        const input = $(this)
        const decimals = $(this).parent().data('decimals') ?? 1
        const ToUnit = new Intl.NumberFormat('id-ID', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: decimals
        });
        var lastCharacter = input.val().substr(input.val().length - 1) ?? 0;

        if (input.val() != '') {
            if (lastCharacter != ',') {
                while (!$.isNumeric(lastCharacter) && input.val() != '') {
                    input.val(input.val().slice(0, -1))
                    lastCharacter = input.val().substr(input.val().length - 1);
                }
            }
        }

        if($.inArray(lastCharacter, allowedKey) !== -1) {
            input.val(ToUnit.format(input.val().replaceAll('.', '').replaceAll(',', '.')))
        }
        else if (lastCharacter == ',') {
            input.val(input.val().replaceAll(',', '') + ",")
        }

        if (input.val() == '' || input.val() == ',') {
            input.val(0)
        }
    })
    $(document).on('change', '.to-unit', function (e) {
        const input = $(this)
        var lastCharacter = input.val().substr(input.val().length - 1);
        while (!$.isNumeric(lastCharacter) && input.val() != '') {
            input.val(input.val().slice(0, -1))
            lastCharacter = input.val().substr(input.val().length - 1);
        }
    })
})
