<template>
  <div>
    <div class="mb-5 pb-5 row">
      <div class="col-md-4 offset-md-4">
        <h4 class="py-3">
          Create Product
        </h4>
        <product-form url="/api/v1/products"></product-form>
      </div>
    </div>
  </div>
</template>

<script>
  import ProductForm from './ProductForm';
  export default {
    components: { ProductForm },
    props: [],
    data() {
      return {};
    },
    computed: {},
    methods: {
      createProduct(form) {
        //
      },
    },
    created() {},
  };
</script>
