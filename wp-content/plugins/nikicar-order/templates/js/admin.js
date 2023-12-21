document.addEventListener('DOMContentLoaded', () => {
    let wpNonce = document.getElementById('wp-nonce').getAttribute('data-wp-nonce');

    let request = function (method, url, param, callback) {
        const xhr = new XMLHttpRequest();
        let body;
        xhr.open(method, url);
        xhr.setRequestHeader('X-WP-Nonce', wpNonce);

        if (method == 'POST') {
            xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
            body = JSON.stringify(param);
        }

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                callback(JSON.parse(xhr.response))
            }
        };

        xhr.send(body);
    }

    document.querySelectorAll('.approve-order-button').forEach((button) => {
        button.addEventListener('click', () => {
            request('POST', '/wp-json/nikicar-order/v1/approveOrder', {orderId:button.getAttribute('data-id')}, (data) => {
                if(data.success){
                    window.location.reload();
                }
            });
        });
    });

    document.querySelectorAll('.close-order-button').forEach((button) => {
        button.addEventListener('click', () => {
            request('POST', '/wp-json/nikicar-order/v1/closeOrder', {orderId:button.getAttribute('data-id')}, (data) => {
                if(data.success){
                    window.location.reload();
                }
            });
        });
    });

    document.querySelectorAll('.paid-order-button').forEach((button) => {
        button.addEventListener('click', () => {
            request('POST', '/wp-json/nikicar-order/v1/paidOrder', {orderId:button.getAttribute('data-id')}, (data) => {
                if(data.success){
                    window.location.reload();
                }
            });
        });
    });
});


[{collectionName: 'Portal',unid: 'ECA12FC8-11D7-739D-96DC-412BEC8E1F57',runid: '168640788064848ac86abcc',added: '20230610T17:38:00,43+03',originalFilename: 'bilbash.jpg'}, {collectionName: 'BlogPreview', unid: '7E97C859-85B4-6DB6-0FBE-95C59712F7F8', runid: '17029957896581a74dd3bb2', added: '20231219T17:23:09,86+03', originalFilename: 'bilbash.jpg'}]