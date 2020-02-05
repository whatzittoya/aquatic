<template>
  <div>
    <!-- <modal v-if="showModal" @close="showModal = false" v-bind:test='form'> -->
    <!-- <modal v-if="showModal" @close="showModal = false"  :edit="edit" :id="id" >
   
  </modal> -->

    <div class="row">

      <div class="col-md-12">
        <!-- <div class="col-md-4">
         
             <button id="show-modal" @click="createData()" class="btn btn-primary">Tambah Member</button>
           
          </div>    -->
        <v-data-table :headers="headers" :items="members" :items-per-page="10" class="elevation-1">
          <template v-slot:item.valid="{ item }">
            {{item.valid ? "Valid":"Tidak Valid"}}
          </template>
          <template v-slot:top>
            <v-toolbar flat color="white">
              <v-toolbar-title>Member</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Member</v-btn>
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
                            <v-select v-model="form.club" :items="clubs" item-text="name" item-value="id"></v-select>

                          </v-col>
                          <v-col cols="12" sm="12" md="6">
                            <v-text-field ref="name" v-model="form.name" label="Nama" :rules="[rules.required]"></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6">
                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                              :return-value.sync="form.born_date" transition="scale-transition" offset-y
                              min-width="290px">
                              <template v-slot:activator="{ on }">
                                <v-text-field v-model="form.born_date" label="Tanggal Lahir" 
                                  readonly v-on="on"></v-text-field>
                              </template>
                              <v-date-picker v-model="form.born_date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                              </v-date-picker>
                            </v-menu>
                            <!-- <v-text-field v-model="form.born_date" label="Tanggal Lahir"></v-text-field> -->
                          </v-col>
                      
                            <v-col cols="12" sm="12" md="6">
                           
                            <v-text-field ref="best_time" v-model="form.best_time" type="time" label="Best Time" step="0.001" :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                              <v-col cols="12" sm="12" md="6">
                            <v-file-input label="Dokumen" accept="image/png, image/jpeg, image/bmp, application/pdf" v-model="form.file"
                              hint="(extension:jpg,jpeg,png,pdf max-size:500KB)" persistent-hint
                              :error-messages="file_error_messages" ></v-file-input>
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

          <template v-slot:item.best_time="{ item }">
            {{ timeFormat(item.best_time) }}
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editData(item)">
              edit
            </v-icon>
            <v-icon small @click="deleteData(item.id)">
              delete
            </v-icon>

            <a :href="'/admin/members/'+item.id"  target="_blank">
       <v-icon small>
        insert_drive_file
      </v-icon></a>
            <!-- <a :href="'/admin/members/'+member.id" target="_blank" class="btn btn-primary">Lampiran</a> -->
          </template>
        </v-data-table>
        <!-- <v-text-field  v-mask="customTokens" label="Best Time" ></v-text-field> -->


      </div>
    </div>
  </div>
</template>

<!-- script js -->
<script>
// import modal from "./ModalMember.vue";

// import { mask } from "vue-the-mask";

export default {
  // directives: {
  //   mask
  // },
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },
    timeToInt: function() {
      // `this` points to the vm instance
      let time = this.form.best_time.split(":");
      if (time.length < 3) {
        time.unshift(0);
      }

      let second = time[2].split(".");

      var milisecond =
        +time[0] * 60 * 60 * 1000 +
        +time[1] * 60 * 1000 +
        +second[0] * 1000 +
        second[1] * 1;
      return milisecond;
    },
    formtest() {
      return {
        name: this.form.name,
        best_time: this.form.born_date
      };
    }
  },
  data() {
    return {
      // variable array yang akan menampung hasil fetch dari api

      // customTokens: {
      //   mask: "HT:HT:TTT",
      //   tokens: {
      //     H: {
      //       pattern: /[0-5]/
      //     },
      //     T: {
      //       pattern: /[0-9]/
      //     }
      //   }
      // },
      rules: {
        required: value => !!value || "Required."
      },
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      file: null,
      setLocale: { value: 1, text: "Tidak Valid" },
      headers: [
        { text: "Nama", value: "name" },
        { text: "Tanggal Lahir", value: "born_date" },
        { text: "Waktu Tercepat", value: "best_time" },
        { text: "Klub", value: "clubs.name" },
        { text: "Valid", value: "valid" },
        { text: "Aksi", value: "action", sortable: false }
      ],
      form: {},
      defaultForm: {},
      clubs: [],
      validation: [
        { text: "Tidak Valid", value: 0 },
        { text: "Valid", value: 1 }
      ],
      members: [],
      file_error_messages: null,
      edit: false,
      id: 0,
      showModal: false,
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
      axios.get("/api/members").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.members = response.data;
        // console.log(response.data);
      });
      axios.get("/api/clubs").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.clubs = response.data;
        this.defaultForm = {
          club: this.clubs[0].id,
          name: "",
          born_date: new Date().toISOString().substr(0, 10),
          best_time: "00:59:59.999",
          document: "",
          valid: 1
        };
        this.form = this.defaultForm;
      });
    },
    fileCheck() {},
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/members/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // edit data
      this.form = Object.assign({}, item);
      this.form.club = item.club_id;
      this.form.best_time = this.timeFormat(item.best_time);

      this.edit = true;
      this.dialog = true;
    },
    createData() {
      // create data
      this.edit = false;
      this.id = 0;
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
        const config = {
          headers: { "content-type": "multipart/form-data" }
        };
        // post data ke api menggunakan axios

        let formData = new FormData();

        formData.append("club_id", this.form.club);
        formData.append("name", this.form.name);
        formData.append("born_date", this.form.born_date);
        formData.append("best_time", this.timeToInt);
        formData.append("file", this.form.file);
        formData.append("filename", this.form.filename);
        formData.append("valid", this.form.valid);
        //if the data for update

        if (this.edit && this.form.id > 0) {
          axios
            .post("/api/members/updateapi/" + this.form.id, formData, config)
            .then(response => {
              // push router ke read data
              this.loadData();
              this.close();
            });
        } else {
          axios.post("/api/members", formData, config).then(response => {
            // push router ke read data
            this.loadData();
            this.close();
          });
        }
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.form = Object.assign({}, this.defaultForm);
        this.edit = false;
      }, 300);
    },
    timeFormat(milisecond) {
      let hour = 0;
      let minute = 0;
      let second = 0;
      let mili = 0;

      hour = Math.floor(milisecond / 3600000);

      if (hour.toString.length < 2) {
        hour = ("0" + hour).slice(-2);
      }
      milisecond = milisecond - hour * 3600000;

      minute = Math.floor(milisecond / 60000);
      minute = ("0" + minute).slice(-2);
      milisecond = milisecond - minute * 60000;
      second = Math.floor(milisecond / 1000);
      second = ("0" + second).slice(-2);
      milisecond = milisecond - second * 1000;
      mili = milisecond;
      mili = ("00" + mili).slice(-3);

      return hour + ":" + minute + ":" + second + "." + mili;
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    "form.file"(val) {
      console.log(val);
      if (val != null) {
        this.form.filename = val.name;
        if (val.size > 1000000) {
          this.file_error_messages = "File size must be less than 1 MB";
        } else {
          this.file_error_messages = null;
        }
      } else {
        this.file_error_messages = null;
      }
    }
  }
};
</script>