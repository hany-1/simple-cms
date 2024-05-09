export function editHtmlBtn(url) {
    return '<a href="' + url + '" class="btn btn-sm btn-outline-primary" title="Edit details">\
    <i class="fa-regular fa-pen-to-square"></i>\
    </a>';
}

export function viewHtmlBtn(url) {
    return '<a href="' + url + '" class="btn btn-sm btn-outline-primary" title="View">\
    <i class="la la-binoculars"></i>\
    </a>';
}

export function deleteHtmlBtn(id) {
    return '<a href="javascript:;" data-id=' + id + ' class="deleteBtn btn btn-sm btn-outline-primary" title="Delete">\
    <i data-id='+ id + ' class="fa-solid fa-trash-can"></i>\
    </a>';
}

export function route(url, parameters) {
    for (var x in parameters) {
        let key = parseInt(x) + 1;
        url = url.replace(":" + key, parameters[x]);
    }
    return url;
}
export function responseErrorMessage(error) {
    var message = {};
    if (error.response.data.errors) {
        message = error.response.data.errors;
    } else if (error.response.data.message) {
        message = error.response.data.message;
    } else {
        message = error.response.data;
    }
    return message;
}
