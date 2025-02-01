document.addEventListener("DOMContentLoaded", function () {
    // 画像プレビュー関数
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.classList.remove("d-none"); // 非表示を解除
                img.style.display = "block"; // 確実に表示
            };
            reader.readAsDataURL(file);
        }
    }

    // 税理士写真プレビュー
    const taxPhotoInput = document.getElementById("tax_accountant_photo");
    if (taxPhotoInput) {
        taxPhotoInput.addEventListener("change", function () {
            previewImage(this, "preview_tax_accountant_photo");
        });
    }

    // その他の写真プレビュー
    const additionalPhotosInput = document.getElementById("additional_photos");
    if (additionalPhotosInput) {
        additionalPhotosInput.addEventListener("change", function (e) {
            const container = document.getElementById("preview_additional_photos");
            container.innerHTML = ""; // 既存のプレビューをクリア

            Array.from(e.target.files).forEach((file) => {
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const imgWrapper = document.createElement("div");
                        imgWrapper.classList.add("m-2");

                        const img = document.createElement("img");
                        img.src = event.target.result;
                        img.classList.add("img-thumbnail");
                        img.style.maxHeight = "100px";

                        imgWrapper.appendChild(img);
                        container.appendChild(imgWrapper);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }
});
