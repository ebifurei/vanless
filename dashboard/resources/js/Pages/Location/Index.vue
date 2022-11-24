<template>
  <LayoutAuthenticated>
    <Head title="Locations" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiMapCheckOutline" title="Locations" main>
        <!--  -->
      </SectionTitleLineWithButton>

      <CardBox>
        <GoogleMap :api-key="googleAPI" style="width: 100%; height: 500px" :center="center" :zoom="15">
          <Marker :options="{ position: center }">
            <InfoWindow>
              <div id="content">
                <div id="siteNotice"></div>
                <h1 id="firstHeading" class="firstHeading">Uluru</h1>
                <div id="bodyContent">
                  <p>
                    <b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large sandstone rock formation in the southern
                    part of the Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) south west of the
                    nearest large town, Alice Springs; 450&#160;km (280&#160;mi) by road. Kata Tjuta and Uluru are the two
                    major features of the Uluru - Kata Tjuta National Park. Uluru is sacred to the Pitjantjatjara and
                    Yankunytjatjara, the Aboriginal people of the area. It has many springs, waterholes, rock caves and
                    ancient paintings. Uluru is listed as a World Heritage Site.
                  </p>
                  <p>
                    Attribution: Uluru,
                    <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">
                      https://en.wikipedia.org/w/index.php?title=Uluru</a>
                    (last visited June 22, 2009).
                  </p>
                </div>
              </div>
            </InfoWindow>
          </Marker>
        </GoogleMap>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import SectionMain from '@/Components/SectionMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { mdiMapCheckOutline } from '@mdi/js';
import CardBox from '@/Components/CardBox.vue';
import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map';

const center = { lat: 40.7128, lng: -74.0060 };
const googleAPI = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

</script>

<style lang="scss" scoped>

</style>
