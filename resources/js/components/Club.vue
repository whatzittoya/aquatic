<template>
  <div>

    <div class="row">

      <div class="col-md-12">
    <v-card-title>
      Klub.
      <v-spacer></v-spacer>
  
    </v-card-title>
 
        <v-data-table :headers="headers" :items="clubs" class="elevation-1" :search="search">
          <template v-slot:top>
            <v-toolbar flat color="white">
   
                  <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
              
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Klub</v-btn>
                </template>
                <v-card>
                  <v-form @keyup.native.enter="save">
                    <v-card-title>
                      <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                      <v-container>
                        <v-row>

                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="name" v-model="form.name" label="Nama" :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="address" v-model="form.address" label="Alamat" :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="city" v-model="form.city" label="Kota" :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="province" v-model="form.province" label="Provinsi"
                              :rules="[rules.required]"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="email" v-model="form.email" label="Email" :rules="emailRules">
                            </v-text-field>
                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="pic" v-model="form.pic" label="PIC" :rules="[rules.required]">
                            </v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6">
                            <v-select :items="validation" label="Validasi" v-model="form.valid"></v-select>
                          </v-col>

                        </v-row>
                      </v-container>
                    </v-card-text>

                    <v-card-actions>
                      <v-spacer></v-spacer>

                      <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>

                      <v-btn color="blue darken-1" text @click="save">Save</v-btn>

                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.valid="{ item }">
            {{item.valid ? "Valid":"Tidak Valid"}}
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editData(item)">
              edit
            </v-icon>
            <v-icon small @click="deleteData(item.id)">
              delete
            </v-icon>


            <!-- <a :href="'/admin/members/'+member.id" target="_blank" class="btn btn-primary">Lampiran</a> -->
          </template>
        </v-data-table>

      </div>
    </div>
  </div>
</template>

<!-- script js -->
<script>
export default {
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },
    formtest() {
      return {
        name: this.form.name,
        address: this.form.address,
        city: this.form.city,
        province: this.form.province,
        pic: this.form.pic
      };
    }
  },
  data() {
    return {
      // variable array yang akan menampung hasil fetch dari api
      rules: {
        required: value => !!value || "Required."
      },
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      headers: [
        { text: "Nama", value: "name" },
        { text: "Alamat", value: "address" },
        { text: "Kota", value: "city" },
        { text: "Provinsi", value: "province" },
        { text: "PIC", value: "pic" },
        { text: "Valid", value: "valid" },
        { text: "Aksi", value: "action", sortable: false }
      ],

      clubs: [],
      edit: false,
      id: 0,
      showModal: false,
      form: {},
      defaultForm: {},
      validation: [
        { text: "Tidak Valid", value: 0 },
        { text: "Valid", value: 1 }
      ],
      edit: false,
      search: "",
      id: 0,
      dialog: false,
      formHasErrors: false
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
      this.defaultForm = {
        name: "",
        address: "",
        city: "",
        province: "",
        pic: "",
        email: "",
        valid: 0
      };
      this.form = this.defaultForm;
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/clubs/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);
      this.form.email = this.form.users.email;
      this.edit = true;
      this.dialog = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.dialog = true;
    },
    save() {
      this.formHasErrors = false;

      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;
        console.log(this.formtest[f]);
        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        // post data ke api menggunakan axios
        if (this.edit && this.form.id > 0) {
          axios
            .put("/api/clubs/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })
            .then(response => {
              // push router ke read data
              this.loadData();
              this.close();
            });
        } else {
          axios.post("/api/clubs", this.form).then(response => {
            // push router ke read data
            this.loadData();
            this.close();
          });
        }
        this.$parent.showModal = false;
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.form = Object.assign({}, this.defaultForm);
        this.edit = false;
        Object.keys(this.formtest).forEach(f => {
          if (!this.formtest[f]) this.formHasErrors = true;
          console.log(this.formtest[f]);
          this.$refs[f].reset();
        });
      }, 300);
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  }
};
</script>