<template>
  <div>
    <!-- button in the middle to send post request -->
    <div class="flex justify-center">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="sendPost">
        Send Post
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  methods: {
    sendPost() {
      // send post request to the server
      axios.post('/uplink/chirpstack?event=up', {
        // data to send
        applicationID: '1',
        applicationName: 'LoraAntiVandalisme',
        deviceName: 'vanless-1',
        devEUI: 'vVnh4aKO7Ho=',
        rxInfo: [
          {
            gatewayID: 'b827ebfffee12e02',
            name: 'vanless-loraserver',
            time: '2019-07-21T11:45:01.389569Z',
            rssi: -41,
            loRaSNR: 5,
            location: {
              latitude: 0,
              longitude: 0,
              altitude: 0,
            },
          },
        ],
        txInfo: {
          frequency: 923200000,
          dr: 5,
        },
        adr: true,
        fCnt: 1,
        fPort: 1,
        data: 'CK4=',
        objectJSON: '{ "Peter": 50, "Ben": 37, "Joe": 43 }',
      },
      )
        .then((response) => {
          // handle success
          console.log(response);
        })
        .catch((error) => {
          // handle error
          console.log(error);
        });
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
