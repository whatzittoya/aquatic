<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              <h3>{{stat_form}} Klub</h3>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              <form action="" @submit.prevent="edit ? updateData() : addData()" method="POST"
                enctype="multipart/form-data">

                <!-- {{test.name}} -->


                <div class="form-group row">
                  <label for="Nama" class="col-sm-2 col-form-label" >Nama Klub</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama" id="t_nama"  v-model="form.name">
    </div>
                  </div>
                  <div class="form-group row">
                    <label for="Nama" class="col-sm-2 col-form-label" >Alamat</label>
                    <div class="col-sm-10">
                      <input type="text"  class="form-control" name="alamat" v-model="form.address">
    </div>
                    </div>
                    <div class="form-group row">
                      <label for="Tanggal" class="col-sm-2 col-form-label">Kota</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="kota" v-model="form.city">
    </div>
                      </div>
                      <div class="form-group row">
                        <label for="Waktu" class="col-sm-2 col-form-label" >Provinsi</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="provinsi" v-model="form.province">
    </div>
                        </div>

                        <div class="form-group row">
                          <label for="Waktu" class="col-sm-2 col-form-label" >PIC</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="pic" v-model="form.pic">
    </div>
                          </div>

                          <button class="btn btn-primary btn-md active" role="button" aria-pressed="true"
                            type="submit">Simpan</button>
                          <button class="btn btn-default" @click.prevent="$emit('close')">
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
      clubs: [],
      stat_form: "",
      form: {
        name: "",
        address: "",
        city: "",
        province: "",
        pic: ""
      }
    };
  },
  created() {
    if (this.edit) {
      this.stat_form = "Edit";
      axios.get("/api/clubs/" + this.id).then(response => {
        // mengirim data hasil fetch ke varibale array persons
        console.log(response.data);
        this.form = response.data;
      });
    } else {
      this.form = {};
      this.stat_form = "Tambah";
    }
  },
  methods: {
    updateData() {
      // post data ke api menggunakan axios

      axios
        .put("/api/clubs/" + this.id, { data: this.form, _method: "patch" })
        .then(response => {
          // push router ke read data
          this.$parent.loadData();
        });
      this.$parent.showModal = false;
    },
    addData() {
      // post data ke api menggunakan axios

      axios.post("/api/clubs", this.form).then(response => {
        // push router ke read data
        this.$parent.loadData();
      });
      this.$parent.showModal = false;
    }
  }
};
</script>