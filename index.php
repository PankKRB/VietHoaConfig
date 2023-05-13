<!DOCTYPE html>
<html>
<head>
    <title>Dịch Config</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-yaml/4.1.0/js-yaml.min.js"></script>

    <style>
        body {
            padding: 20px;
        }
        #resultText {
            min-height: 200px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
        }
        .loading-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loading-popup .content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .loading-popup .loading-image {
            margin-bottom: 10px;
        }
        .download-button {
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }
.popup {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    animation: popup-appear 0.3s ease-out;
    z-index: 9999; /* Giá trị z-index lớn hơn */
}
.popup-overlay {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0; /* Bắt đầu với độ mờ 0 */
    transition: opacity 0.3s ease-out; /* Hiệu ứng chuyển đổi mờ */
}
.popup-overlay.active {
    display: block;
    opacity: 1; /* Độ mờ 1 khi popup được kích hoạt */
}

        
        @keyframes popup-appear {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <button id="guideButton" class="btn btn-primary">Hướng dẫn</button>
        <div id="popup" class="popup">
            <h2>Hướng dẫn</h2>
            <p>Hiện Tại Website Chỉ Dịch Được Những Đoạn Như sau<br>
            <ul>
  <li>name: "text"</li>
  <li>name: 'text'</li>
  <li>name: text</li>
  <li>name: '&atext'</li>
</ul>ví dụ như<ul><li>setting1: "This is the first setting"</li>
<li>setting2: 'This is the second setting'</li>
<li>setting3: This is the third setting</li>
<li>setting4: 'This is the second setting'</li></ul></p>
            <button id="closeButton" class="btn btn-secondary">Đóng</button>
        </div>
        <div id="popupOverlay" class="popup-overlay"></div>
        <h1>Dịch Config</h1>
        <p>Chỉ Dịch File Language (Ngôn Ngữ)</p>
        <p>LƯU Ý: SAU KHI DỊCH XONG FILE MÀ MUỐN DỊCH TIẾP THÌ VUI LÒNG TẢI LẠI TRANG</p>

            <div class="form-group">
        <label for="configInput">Paste Config vào đây:</label>
        <textarea class="form-control" id="configInput" rows="5"></textarea>
    </div>
    <br>
    <p>HOẶC</p>
        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="configFile" name="configFile">
            <label class="custom-file-label" for="configFile">Bấm Vào Đây Để Chọn File | Kéo File Vào Đây</label>
        </div>
        <button id="button" class="btn btn-primary mb-3">Dịch</button>
        <div class="loading-popup" id="loadingPopup" style="display: none;">
<div class="content">
    <img src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="50px" class="loading-image" alt="Loading...">
    <div class="loading-message">Đang dịch...</div>
    <div class="loading-message">Nếu dịch quá lâu thì là do file của bạn khá nặng <br>nên đợi tầm 3-5 phút để có thể hoàn thành</div>
</div>

        </div>
        <textarea id="resultText" class="form-control" placeholder="Translated text will appear here..." style="display: none;"></textarea>
        <a href="#" class="btn btn-success download-button" id="downloadButton" style="display: none;">Tải File Dịch</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
        $(document).ready(function() {
            $('#guideButton').click(function() {
                $('#popup').show();
            });
            $('#closeButton').click(function() {
                $('#popup').hide();
            });
            $('#dongButton').click(function() {
                $('#thongbao').hide();
            });
        });
    $('#configFile').change(function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });


    $('#button').click(function(){
        var configText = $('#configInput').val();
        var file = document.getElementById('configFile').files[0];
        if (configText) {
            $('#loadingPopup').show();
            setTimeout(function() {
                $('#loadingPopup').hide();
                var translatedText = translate(configText);
                $('textarea#resultText').val(translatedText).show();
                $('#downloadButton').attr('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(translatedText)).attr('download', 'translated_config.txt');
                $('#downloadButton').show();
            }, 500); 
        }
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, "UTF-8");
            reader.onload = function (evt) {
                $('#loadingPopup').show();
                setTimeout(function() {
                    $('#loadingPopup').hide();
                    var translatedText = translate(evt.target.result);
                    $('textarea#resultText').val(translatedText).show();
                    $('#downloadButton').attr('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(translatedText)).attr('download', file.name);
                    $('#downloadButton').show();
                }, 500);
            }
        }
    });

function translate(sourceText) {
    var sourceLang = 'en';
    var targetLang = 'vi';
    var matches = sourceText.match(/.*: (.*)/g);
    if (!matches) return;
    var translationsDone = 0;
    var translatedText = sourceText;

    matches.forEach(function(match) {
        var textToTranslate = match.match(/: (.*)/)[1];
        if (textToTranslate.trim() === 'true' || textToTranslate.trim() === 'false' || textToTranslate.trim() === 'disabled' || textToTranslate.trim() === 'enabled') {
            translationsDone++;
            return;
        }
        
        // Kiểm tra nếu từ đằng sau dấu & là số
        if (textToTranslate.startsWith('&') && /^\d+$/.test(textToTranslate.substr(1))) {
            translationsDone++;
            return;
        }
        
        // Kiểm tra nếu cấu trúc chứa dấu <pos>
        if (textToTranslate.includes('<pos>')) {
            translationsDone++;
            return;
        }
        
        // Kiểm tra nếu từ có chữ hoa ở đầu
        if (/^[A-Z]/.test(textToTranslate)) {
            translationsDone++;
            return;
        }

        // Thay thế dấu < và > bằng [ và ]
        textToTranslate = textToTranslate.replace(/<pos>/g, '[pos]');
        textToTranslate = textToTranslate.replace(/{(\d)}/g, '[$1]');

        // Tách phần dịch bên trong dấu && và phần còn lại
        var innerTranslation = '';
        var outerText = textToTranslate.replace(/(\&\&.*?\&\&)/g, function(match) {
            innerTranslation = match;
            return '';
        });
        
        // Split the string into parts based on special characters
        var parts = outerText.split(/(&\w)/);
        
        parts.forEach(function(part, index) {
            // Only translate parts that do not start with a special character
            if (!part.startsWith('&') && part !== '%%' && !/prefix/i.test(part)) {
                var url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl="+ sourceLang + "&tl=" + targetLang + "&dt=t&q=" + encodeURI(part);
                $.ajax({
                    url: url,
                    success: function(data) {
                        var translatedValue = data[0][0][0];
                        // Replace the original part with the translated part
                        parts[index] = translatedValue;
                        translationsDone++;
                        
                        var progress = Math.round((translationsDone / matches.length) * 100);
                        $('#progressMessage').text(progress + "%");

                        if(translationsDone === matches.length) {
                            $('#loadingMessage').hide();
                        }
                    },
                    async: false
                });
            }
        });
        
                // Join the translated parts back together
        var fullTranslatedValue = parts.join('');

        // Thay thế lại dấu [ và ] thành < và >
        fullTranslatedValue = fullTranslatedValue.replace(/\[pos\]/g, '<pos>');
        fullTranslatedValue = fullTranslatedValue.replace(/\[(\d)\]/g, '{$1}');

        // Nếu có phần dịch bên trong dấu &&
        if (innerTranslation) {
            // Thay thế phần dịch bên trong bằng chính nó
            fullTranslatedValue += ' ' + innerTranslation;
        }

        translatedText = translatedText.replace(textToTranslate, fullTranslatedValue);
    });
        
    return translatedText;
}




$(document).ready(function() {
    $("#thongbao").fadeIn();
});


</script>

<div id="thongbao" class="popup">
            <center><h2>Thông Báo</h2></center>
            <center><p>Hiện Tại Website Đã Có Thể Dịch Được Hầu Hết Config<br>Tham Gia <a style="color: blue;" href="https://discord.gg/Hgt4Y7KRNT"> DISCORD </a>Để Nhận 1 Số Thông Báo Và<br>Báo Lỗi Trong Quá Trình Sử Dụng Web
            </p></center>
            <button id="dongButton" class="btn btn-secondary">Đóng</button>
        </div>

    <footer>
        <div class="footer">
            <p class="text-center">Code by Hoàng Kiệt</p>
        </div>
    </footer>
</body>
</html>
