let searchForm = document.querySelector(".search-form");

document.querySelector("#search-btn").onclick = () => {
    searchForm.classList.toggle("active");
    shoppingCart.classList.remove("active");
    loginForm.classList.remove("active");
    navbar.classList.remove("active");
};


let swiperCards = new Swiper(".review-content", {
    loop: true,
    spaceBetween: 32,
    grabCursor: true,
  
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
  
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  
    breakpoints:{
      600: {
        slidesPerView: 2,
      },
      968: {
        slidesPerView: 4,
      },
    },
  });



  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('kosongkanForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Kirim request AJAX
        fetch(this.action, {
            method: this.method,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: new URLSearchParams(new FormData(this))
        })
        .then(response => response.json())
        .then(data => {
            // Tampilkan pesan pop-up
            alert(data.message); // Ubah sesuai dengan format respons yang Anda kirimkan dari server
            // Refresh halaman atau lakukan tindakan lain jika diperlukan
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });
});


