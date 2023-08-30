<template>
  <div>
      <nav class="navbar navbar-dark bg-dark fixed-top">
          <div class="container">
              <a class="navbar-brand fw-bold">GOFIT GYM</a>
              <div class="d-flex justify-content-end">
                  <router-link :to="{ name: 'login' }" class="btn btn-md btn-primary">Login</router-link>
              </div>
          </div>
      </nav>
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
          <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                  aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                  aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                  aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
              <div class="carousel-item active">
                  <img src="https://wallsdesk.com/wp-content/uploads/2016/10/Gym-for-desktop.jpg"
                      class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>SELAMAT DATANG DI GYM</h5>
                      <p>Kami memberikan pengalaman berloahraga yang mudah dan efisien</p>
                  </div>
              </div>
              <div class="carousel-item">
                  <img src="https://dm0qx8t0i9gc9.cloudfront.net/thumbnails/video/rCR4u8bygiud1h6sl/videoblocks-the-interior-of-an-empty-gym_bemcxtfgim_thumbnail-1080_12.png"
                      class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>ALAT DAN KELAS TERJAMIN BERKUALITAS</h5>
                      <p>Semua alat gym dan kelas yang disediakan memiliki kualitas yang terbaik.</p>
                  </div>
              </div>
              <div class="carousel-item">
                  <img src="https://images.pexels.com/photos/6456140/pexels-photo-6456140.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                      class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>INSTRUKTUR DAN KARYAWAN YANG BAIK DAN RAMAH</h5>
                      <p>Kenyamanan dan keamanan pelanggan dalam berolahraga merupakan prioritas utama kami</p>
                  </div>
              </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
          </button>
      </div>
  </div>
</template>

<script>
</script>

<style>
  * {
      font-family: "Poppins";
  }
  h2 {
      font-size: 50px;
      -webkit-text-stroke: 2px red;
  }
  .carousel-caption{
      background-color: black;
      opacity: 75%;
      border-radius: 10px;
  }
  .carousel-item {
      max-height: 730px;
  }
</style>