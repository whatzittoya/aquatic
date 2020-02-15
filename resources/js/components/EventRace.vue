<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Lomba Event
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="races" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <!-- <v-select v-model="event" :items="events" item-text="name" item-value="id"
                                label="event" ></v-select> -->
                     <v-select v-model="event" :items="events"
                                                            item-text="name" item-value="id" label="Pilih Event"
                                                      ></v-select>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Lomba</v-btn>
                                </template>
                                <v-card>
                                    <v-form @keyup.native.enter="save">
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>

                                                <v-row>
 <v-col cols="12" sm="12" md="12">
                                 <v-select v-model="race_selected" :items="races_select"
                                                            item-text="name" item-value="id" label="Lomba"
                                                           return-object ></v-select>
                                                    </v-col>
                                                   
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field  v-model="form.race_number"
                                                            label="Nomor"  disabled="">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.rule"
                                                            label="Kategori" 
                                                             disabled="">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                  <v-text-field  v-model="form.gender"
                                                            label="Gender"  disabled="">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.style" label="Gaya"
                                                            disabled>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="form.distance"
                                                            label="Jarak" disabled>
                                                        </v-text-field>
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
                <!-- <v-select v-model="a.currentItem" :items="items"></v-select> -->
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
    }
  },

  data() {
    return {
      id: "",
      ruleselected: {},

      headers: [
        { text: "Nama", value: "name" },
        { text: "Kategori", value: "rule.name" },
        { text: "Nomor", value: "race_number" },
        { text: "Jenis Kelamin", value: "gender" },
        { text: "Gaya", value: "style" },
        { text: "Jarak", value: "distance" },
        { text: "Aksi", value: "action", sortable: false }
      ],
      races: [],
      genders: [{ text: "Laki-laki" }, { text: "Perempuan" }],
      races: [],
      rules_race: [],
      edit: false,
      errors: [{ a: 123 }, { b: 1233 }],
      showModal: false,

      events: [],
      event: "",
      races_select: [],
      race_selected: "",

      form: {},
      defaultForm: {},
      formerrors: {
        race_number: "",
        name: ""
      },
      search: "",
      dialog: false,
      formHasErrors: false,

      ruletext: "",
      disablewatch: false
    };
  },
  created() {
    this.id = this.$route.params.id;
    this.loadData();
  },

  methods: {
    loadData() {
      if (this.id > 0) {
        axios.get("/api/races/byevent/" + this.id).then(response => {
          this.races = response.data;
        });
      }
      axios.get("/api/races").then(response => {
        this.races_select = response.data;
        this.race_selected = this.races_select[0];
      });
      axios.get("/api/events").then(response => {
        this.events = response.data;
      });
      this.defaultForm = {
        name: "",
        race_number: "",
        gender: "Laki-laki",
        style: "",
        distance: ""
      };
      this.form = this.defaultForm;
      axios.get("/api/rules").then(response => {
        this.rules_race = response.data;
        this.ruleselected = this.rules_race[0];
      });
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/races/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);
      this.race_selected = this.form.id;
      this.edit = true;
      this.dialog = true;
      this.disablewatch = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.dialog = true;
    },
    save() {
      this.formHasErrors = false;
      this.form.rule = this.ruleselected.id;

      let formData = new FormData();
      formData.append("race_id", this.race_selected.id);
      formData.append("event_id", this.id);

      if (this.edit && this.form.id > 0) {
        axios
          .post("/api/events/racesupdate/" + this.form.id, formData)

          .then(response => {
            // push router ke read data
            this.loadData();
            this.close();
          });
      } else {
        axios.post("/api/events/racesstore", formData).then(response => {
          // push router ke read data

          this.loadData();
          this.close();
        });
      }
    },
    close() {
      this.disablewatch = false;
      this.dialog = false;

      setTimeout(() => {
        this.form = this.defaultForm;
        this.edit = false;
      }, 300);
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    event(val) {
      this.id = val;
      this.loadData();
    },
    race_selected(val) {
      this.form = Object.assign({}, val);

      this.form.rule = this.form.rule.name;
    }
  }
};
</script>