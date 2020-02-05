<template>
  <div>
        <!-- <modal v-if="showModal" @close="showModal = false" v-bind:test='form'> -->
  <modal v-if="showModal" @close="showModal = false"  :edit="edit" :id="id" >
   
  </modal>

    <div class="row">

      <div class="col-md-12">
         <div class="col-md-4">
            <!-- push router ke form membuat data -->
             <button id="show-modal" @click="createData()" class="btn btn-primary">Tambah Clubs</button>
            <!-- <router-link class="btn btn-primary w-100" to="/admin/member/new">+ Tambah</router-link> -->
          </div>   
     <v-data-table
    :headers="headers"
    :items="clubs"
   
    class="elevation-1"
  >
<template v-slot:item.best_time="{ item }">
      {{ timeFormat(item.best_time) }}
    </template>
    <template v-slot:item.action="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editData(item.id)"
      >
        edit
      </v-icon>
      <v-icon
        small
        @click="deleteData(item.id)"
      >
        delete
      </v-icon>
     
     
      <!-- <a :href="'/admin/members/'+member.id" target="_blank" class="btn btn-primary">Lampiran</a> -->
    </template>
  </v-data-table>
        <div class="row">
     
         
        </div>
        <br>
        
      </div>
    </div>
  </div>
</template>

<!-- script js -->
<script>
import modal from "./ModalClub.vue";

export default {
  components: {
    modal
  },

  data() {
    return {
      // variable array yang akan menampung hasil fetch dari api

      headers: [
        { text: "Nama", value: "name" },
        { text: "Alamat", value: "address" },
        { text: "Kota", value: "city" },
        { text: "Provinsi", value: "province" },
        { text: "PIC", value: "pic" },
        { text: "Aksi", value: "action", sortable: false }
      ],

      clubs: [],
      edit: false,
      id: 0,
      showModal: false
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData() {
      // fetch data dari api menggunakan axios
      axios.get("/api/clubs").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.clubs = response.data;
        // console.log(response.data);
      });
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/clubs/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(id) {
      // delete data
      this.edit = true;
      this.id = id;
      this.showModal = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.id = 0;
      this.showModal = true;
    }
  }
};
</script>