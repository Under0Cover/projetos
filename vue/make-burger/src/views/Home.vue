<template>
  <Banner />
  <div class="main-container">
    <h1>Monte o seu Burguer:</h1>
    <BurguerFrom />
  </div>
</template>

<script>
import Banner from '../components/Banner.vue';
import BurguerFrom from '../components/BurguerForm.vue';

export default {
  name: "Home",
  components: {
    Banner,
    BurguerFrom
  }
}

</script>
