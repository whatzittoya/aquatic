
</style>
<template>
<transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
             <h3>{{stat_form}} Member</h3>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
             <form action="" @submit.prevent="edit ? updateData() : addData()" method="POST" enctype="multipart/form-data">

    <!-- {{test.name}} -->
  
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Klub</label>
    <div class="col-sm-10">
      <select class="custom-select" name="klub" v-model="form.club">

   <option v-for="club in clubs" :value="club.id">{{club.name}}</option>
 
    </select>

    </div>
  </div>
  <div class="form-group row">
    <label for="Nama" class="col-sm-2 col-form-label" >Nama Member</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nama" id="t_nama"  v-model="form.name">
    </div>
  </div>
   <div class="form-group row">
    <label for="Nama" class="col-sm-2 col-form-label" >Email</label>
    <div class="col-sm-10">
      <input type="email" :disabled="edit" class="form-control" name="nama" id="t_nama"  v-model="form.email">
    </div>
  </div>
  <div class="form-group row">
    <label for="Tanggal" class="col-sm-2 col-form-label">Tanggal Lahir</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" name="tanggal_lahir" v-model="form.born_date">
    </div>
  </div>
    <div class="form-group row">
    <label for="Waktu" class="col-sm-2 col-form-label" >Waktu Tercepat</label>
    <div class="col-sm-10">
      <input type="time" class="form-control" name="waktu" id="waktu" v-model="form.best_time" step="0.001" >
    </div>
  </div>
    <!-- <div class="form-group row">
    <label for="Dokumen" class="col-sm-2 col-form-label">Dokumen</label>
    <div class="col-sm-10">
      <div class="input-group mb-3">
  <div class="custom-file">
    <input type="file" class="custom-file-input" name="dokumen" @change="processFile($event)"> 
    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
  </div>
  <div class="input-group-append">
    <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
  </div>
</div>
    </div>
  </div> -->
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Valid</label>
    <div class="col-sm-10">
      <select class="custom-select" name="klub" v-model="form.valid">

   <option value="1" >Valid</option>
   <option value="0">Tidak Valid</option>
 
    </select>

    </div>
  </div>

  <button class="btn btn-primary btn-md active" role="button" aria-pressed="true" type="submit">Simpan</button>
     <button  class="btn btn-default" @click.prevent="$emit('close')">
                Batal
              </button>
             </form>  

            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
                     
           
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  props: {
    edit: {
      type: Boolean
    },
    id: {
      type: Number
    }
  },
  data() {
    return {
      languages: [
        { shortCode: "en", text: "English" },
        { shortCode: "pl", text: "Polski" },
        { shortCode: "es", text: "Español" },
        { shortCode: "pt", text: "Portugues" }
      ],
      fetchedLocale: "",
      setLocale: null,
      clubs: [],
      stat_form: "",
      form: {
        club: "1",
        name: "",
        born_date: "",
        best_time: "",
        document: "",
        valid: "0"
      }
    };
  },
  created() {
    this.loadDataClub();
    if (this.edit) {
      this.stat_form = "Edit";
      axios.get("/api/members/" + this.id).then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.form = response.data;
        this.form.club = this.form.clubs.id;
        this.form.email = this.form.users.email;
        this.form.best_time = this.$parent.timeFormat(this.form.best_time);
      });
    } else {
      this.form = {};
      this.form.valid = 0;
      this.stat_form = "Tambah";
    }
  },
  methods: {
    loadDataClub() {
      // fetch data dari api menggunakan axios
      axios.get("/api/clubs").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.clubs = response.data;
      });
    },
    processFile(event) {
      this.form.document = event.target.files[0];
    },
    updateData() {
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      // post data ke api menggunakan axios

      let formData = new FormData();

      formData.append("club_id", this.form.club);
      formData.append("name", this.form.name);
      formData.append("born_date", this.form.born_date);
      formData.append("best_time", this.timeToInt);
      formData.append("document", this.form.document);
      formData.append("valid", this.form.valid);

      axios
        .post("/api/members/updateapi/" + this.id, formData, config)
        .then(response => {
          // push router ke read data
          this.$parent.loadData();
        });
      this.$parent.showModal = false;
    },
    addData() {
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      // post data ke api menggunakan axios

      let formData = new FormData();

      formData.append("club_id", this.form.club);
      formData.append("name", this.form.name);
      formData.append("born_date", this.form.born_date);
      formData.append("best_time", this.timeToInt);
      formData.append("valid", this.form.valid);
      formData.append("email", this.form.email);
      axios.post("/api/members", formData, config).then(response => {
        // push router ke read data
        this.$parent.loadData();
      });
      this.$parent.showModal = false;
    }
  },
  computed: {
    // a computed getter
    timeToInt: function() {
      // `this` points to the vm instance
      let time = this.form.best_time.split(":");
      let second = time[2].split(".");

      var milisecond =
        +time[0] * 60 * 60 * 1000 +
        +time[1] * 60 * 1000 +
        +second[0] * 1000 +
        second[1] * 1;
      return milisecond;
    }
  }
};
</script>