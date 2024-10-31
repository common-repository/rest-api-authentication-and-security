function rfapi_check_all_sub_routes(parent_namespace, id) {
    jQuery('input[data-parent-namespace="' + parent_namespace + '"]').prop('checked', jQuery('#parent_namespace_' + id).is(":checked"));
}

function rfapi_redirect_to_url(url) {
    window.location = url;
}

function rfapi_select_encode_method() {
    var selectedMethod = document.getElementById("encode_method").value;
    var examples = document.querySelectorAll(".rfapi-example");
    examples.forEach(function(example) {
        example.style.display = (example.id === selectedMethod) ? "block" : "none";
    });
}

rfapi_select_encode_method();