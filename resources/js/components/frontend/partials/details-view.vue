<template>
  <div v-if="productDetails.id">
    <div class="row">
      <div
          :class="{ 'col-lg-4 col-md-12': $route.name == 'product.details', 'col-lg-5': $route.name != 'product.details' }"
          v-if="lengthCounter(productDetails.gallery) > 0">
        <div class="product-slider-section slider-arrows">
          <div>
            <CoolLightBox style="direction: ltr;"
                          :items="productDetails.gallery.large"
                          :index="index"
                          :useZoomBar="true"
                          @close="index = null">
            </CoolLightBox>

            <div class="images-wrapper">
              <div class="image" v-for="(image, imageIndex) in productDetails.gallery.large" :key="imageIndex"
                   :style="{ backgroundImage: 'url(' + image + ')' }">
              </div>
            </div>
          </div>

          <div class="product-image">
            <img @click="index = current_index" :src="large_image" :alt="productDetails.product_name">
          </div>

          <VueSlickCarousel v-bind="slick_settings" :rtl="settings.text_direction == 'rtl'">
            <div v-for="(image, small_image_index) in productDetails.gallery.small" :key="small_image_index"
                 :class="{ 'active' : small_image_index == current_index }" @click="activeImage(small_image_index)"
                 class="thumb-item">
              <div class="thumbnail-img">
                <img :src="image" :alt="productDetails.product_name">
              </div>
            </div>
          </VueSlickCarousel>

          <span class="base" v-if="productDetails.special_discount_check > 0">
						{{
              productDetails.special_discount_type == "flat" ? priceFormat(productDetails.special_discount_check) + " " + lang.off : productDetails.special_discount_check + "% " + lang.off
            }}
					</span>
          <productVideo v-if="productDetails.video_link" :productDetails="productDetails"></productVideo>
        </div>
      </div>
      <div
          :class="{ 'col-lg-8 col-md-12': $route.name == 'product.details', 'col-lg-7': $route.name != 'product.details' }">
        <div class="row justify-content-md-center">
          <div
              :class="{ 'col-lg-8 col-md-8': $route.name == 'product.details', 'col-lg-12': $route.name != 'product.details' }">
            <div class="product-details-2">
              <div class="product-details-header">
                <h2>{{ productDetails.product_name }}</h2>
                <div class="product-code" v-if="stockFind() && stockFind().sku && attributes_fetched">
                  <ul class="global-list d-flex">
                    <li>{{ lang.SKU }}: {{ stockFind().sku }}</li>
                  </ul>
                </div>
                <div class="sg-rating" v-if="productDetails.rating > 0">
                  <h3>{{ productDetails.rating.toFixed(2) }} </h3>
                  <star-rating v-model:rating="productDetails.rating" :read-only="true" :star-size="12"
                               :round-start-rating="false" class="rating-position"></star-rating>
                  <span class="rating"> ({{ productDetails.reviews_count }} {{ lang.reviews }})</span>
                </div>
              </div>
              
              <!-- Variations Display as Dropdowns -->
              <div class="sg-product-size" v-for="(attribute, attribute_index) in attributes" :key="'attribute' + attribute_index" v-if="attributes.length > 0">
                <div class="sg-size">
                  <h5>{{ attribute.title }}:</h5>
                  <select v-model="product_form.attribute_values[attribute_index]" @change="attributeSelect($event.target, attribute.id, $event.target.value)" class="form-select">
                    <option v-for="(value, value_index) in productDetails.attribute_values" :key="'value' + value_index" :value="value.id" :disabled="checkDisable(attribute_index, value)">
                      {{ value.value }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="sg-product-color" v-if="productDetails.product_colors && productDetails.colors.length > 0">
                <div class="sg-color">
                  <h5>{{ lang.color }}:</h5>
                  <select v-model="product_form.color_id" @change="attributeSelect($event.target)" class="form-select">
                    <option v-for="(color, index) in productDetails.product_colors" :key="'color' + index" :value="color.id">
                      {{ color.name }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Other sections remain unchanged -->
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import shimmer from "../partials/shimmer";
import StarRating from "vue-star-rating";
import loading_button from "./loading_button";
import productVideo from "./product-video";
import single_seller from "./single_seller";

export default {
  name: "details-view",
  props: ["productDetails"],
  data() {
    return {
      product_form: {
        attribute_values: [],
        color_id: null,
        quantity: 1,
      },
      attributes: [],
      attributes_fetched: false,
      large_image: '',
      current_index: 0,
      slick_settings: {
        dots: false,
        arrows: true,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
          {
            breakpoint: 1024,
            settings: { slidesToShow: 3, slidesToScroll: 3 },
          },
        ],
      },
    };
  },
  mounted() {
    if (this.productDetails && this.productDetails.form) {
      this.product_form.quantity = this.productDetails.form.quantity;
      this.product_form.attribute_values = this.productDetails.form.attribute_values;
      this.large_image = this.productDetails.gallery.large[0];
      if (this.productDetails.attribute_selector == 1) {
        this.getAttributes();
      }
    }
  },
  methods: {
    attributeSelect(el, index, value) {
      this.fetchAttributeStock(value);
    },
    fetchAttributeStock(value) {
      // Logic for fetching attribute stock
    },
    getAttributes() {
      // Logic for getting attributes
    },
    checkDisable(index, value) {
      // Logic for disabling unavailable attributes
    },
    stockFind() {
      // Logic for fetching stock details
    },
  },
  components: {
    VueSlickCarousel,
    shimmer,
    StarRating,
    loading_button,
    productVideo,
    single_seller,
  },
};
</script>

<style>
.form-select {
  width: 100%;
  padding: 10px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
