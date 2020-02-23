<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Event
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="events" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Event</v-btn>
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
                                                        <v-text-field ref="name" v-model="form.name" label="Nama"
                                                            :rules="[rules.required]"></v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-menu ref="menu_start" v-model="menu_start"
                                                            :close-on-content-click="false"
                                                            :return-value.sync="form.start_date"
                                                            transition="scale-transition" offset-y min-width="290px">
                                                            <template v-slot:activator="{ on }">
                                                                <v-text-field v-model="form.start_date"
                                                                    label="Tanggal Mulai" readonly v-on="on"
                                                                    ref="start_date"></v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="form.start_date"
                                                                :max="form.end_date" no-title scrollable :min="date">
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="menu_start = false">
                                                                    Cancel</v-btn>
                                                                <v-btn text color="primary"
                                                                    @click="$refs.menu_start.save(form.start_date)">OK
                                                                </v-btn>
                                                            </v-date-picker>
                                                        </v-menu>
                                                        <!-- <v-text-field v-model="form.born_date" label="Tanggal Lahir"></v-text-field> -->
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-menu ref="menu_end" v-model="menu_end"
                                                            :close-on-content-click="false"
                                                            :return-value.sync="form.end_date"
                                                            transition="scale-transition" offset-y min-width="290px">
                                                            <template v-slot:activator="{ on }">
                                                                <v-text-field v-model="form.end_date"
                                                                    label="Tanggal Selesai" readonly v-on="on"
                                                                    ref="end_date">
                                                                </v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="form.end_date" no-title scrollable
                                                                :min="form.start_date">
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="menu_end = false">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn text color="primary"
                                                                    @click="$refs.menu_end.save(form.end_date)">OK
                                                                </v-btn>
                                                            </v-date-picker>
                                                        </v-menu>

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
                           <template v-slot:item.race="{ item }">
                        <v-btn color="info" dark  :to="'/admin/event/races/'+ item.id">Tambah Lomba</v-btn>
                    </template>
                     <template v-slot:item.participant="{ item }">
                        <v-btn color="success" dark  :to="'/admin/event/participants/'+ item.id">Tambah Peserta</v-btn>
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
                <loading :active.sync="isLoading" 
        :can-cancel="false" 
   
        :is-full-page="fullPage"></loading>
    </div>
</template>

<!-- script js -->
<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading
  },
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },
    formtest() {
      return {
        name: this.form.name,
        start_date: this.form.start_date,
        end_date: this.form.end_date
      };
    }
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,
      rules: {
        required: value => !!value || "Required."
      },
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      menu_start: false,
      menu_end: false,
      headers: [
        { text: "Nama", value: "name" },
        { text: "Tanggal Mulai", value: "start_date" },
        { text: "Tanggal Selesai", value: "end_date" },
        { text: "Lomba", value: "race", sortable: false },
        { text: "Peserta", value: "participant", sortable: false },
        { text: "Aksi", value: "action", sortable: false }
      ],

      events: [],
      edit: false,

      showModal: false,
      form: {},
      defaultForm: {},
      search: "",
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
      axios.get("/api/events").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.events = response.data;
        // console.log(response.data);
      });
      this.defaultForm = {
        name: "",
        start_date: new Date().toISOString().substr(0, 10),
        end_date: new Date(new Date().setDate(new Date().getDate() + 7))
          .toISOString()
          .substr(0, 10)
      };
      this.form = this.defaultForm;
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/events/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);
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
          this.isLoading = true;
          axios
            .post("/api/events/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })
            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            });
        } else {
          this.isLoading = true;
          axios.post("/api/events", this.form).then(response => {
            // push router ke read data
            this.loadData();
            this.isLoading = false;
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
        Object.keys(this.formtest).forEach(f => {
          if (!this.formtest[f]) this.formHasErrors = true;
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