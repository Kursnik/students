(function (Module, $) {
    function createHtmlRow(rowData) {
        let row = $('<tr>');
        for (let i in rowData) {
            row.append($('<td>', {html: rowData[i]}));
        }

        return row;
    }

    function getData(url) {
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $('form').serialize(),
            success: function (response) {
                const tableBody = $('#content-container');
                tableBody.empty();
                for (let i in response) {
                    tableBody.append(createHtmlRow(response[i]));
                }
            }
        })
    }

    function initCheckboxes(url) {
        $('table input:checkbox').on('change', function () {
            getData(url);
        });
    }

    function initRefresh(url) {
        let refreshInterval;

        $('#refresh').on('change', function() {
            let time =  $(this).val() * 1000;

            clearInterval(refreshInterval);

            if (!time) {
                return;
            }

            refreshInterval = setInterval(
                function() {
                    getData(url);
                },
                time
            );
        });
    }

    $.extend(Module, {
        init: function (url) {
            initCheckboxes(url);
            initRefresh(url);
        }
    });
})(Students = window.Students || {}, $);