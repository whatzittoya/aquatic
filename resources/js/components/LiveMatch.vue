<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Hasil Pertandingan
                    <v-spacer></v-spacer>
                </v-card-title>
      
                     <v-select v-model="event" :items="events"
                     item-text="name" item-value="id" label="Pilih Event" return-object=""></v-select>
     <h3>   
<img src="/img/logo-sm.png" width="70px"></img>
  <span style="text-align:center">                  
{{matches.name}}</span></h3>
                   
                    
                       <v-divider></v-divider>

                     <div v-for="match in matches.races">
                       <div v-if="match.participants_result.length>0">
                           <v-container class="grey lighten-3">
                          <v-row no-gutters >
                          
                            <v-col cols="6" xs="6" sm="6" md="2" >
                             <p class="font-weight-regular">No Lomba</p>
                         </v-col>
                            <v-col cols="6" xs="6"  sm="6" md="4">
                             <p class="font-weight-bold">{{match.race_number}}</p>
                         </v-col>
                       
                                        <v-col cols="6" xs="6"  sm="6" md="2">
                             <p class="font-weight-regular">Nama Lomba</p>
                     </v-col>
                             <v-col cols="6" xs="6"  sm="6" md="4">
                      <p class="font-weight-bold">{{match.pure_races.name}} </p>
                         </v-col>
                       </v-row>
                          <v-row no-gutters>
                            <v-col cols="6" xs="6" sm="6" md="2" >
                             <p class="font-weight-regular">Gender</p>
                         </v-col>
                            <v-col cols="6" xs="6"  sm="6" md="4">
                             <p class="font-weight-bold">{{match.gender}}</p>
                         </v-col>
                          </v-row>
                           </v-container>
                        <v-row no-gutters>
                              <div v-for="rule in match.rules" style="width:100%">
                            
                                 <div v-if="countParticipantRule(match.participants_result,rule.id)>0">
                                  <h5 style="margin-top:10px">Kategori {{rule.name}}</h5>
                       <v-data-table :headers="headers" :items="filterRule(match.participants_result,rule.id)" class="elevation-1" :search="search" >
        <template v-slot:item.best_time="{ item }">
            {{ timeFormat(item.best_time) }}
          </template>
  
                       </v-data-table>
                                 </div>
                             
                              </div>
                       </v-row>
                       <v-divider></v-divider>
                     </div>
                     </div>
            </div>
        </div>
          
    </div>
</template>

<!-- script js -->
<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import Pusher from "pusher-js";
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
        result: this.form.result,
        best_time: this.form.best_time
      };
    },
    timeToInt: function() {
      // `this` points to the vm instance
      let time = this.form.best_time.split(":");
      if (time.length < 3) {
        time.unshift(0);
      }

      let second = time[2].split(".");
      var ms = 0;
      if (second.length == 1) {
        ms = 0;
      } else if (second.length > 1) {
        ms = second[1];
      }
      var milisecond =
        +time[0] * 60 * 60 * 1000 +
        +time[1] * 60 * 1000 +
        +second[0] * 1000 +
        ms * 1;
      return milisecond;
    }
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,

      menu: false,
      menu_start: false,
      menu_end: false,
      headers: [
        { text: "Nama", value: "member.name" },
        { text: "Tanggal Lahir", value: "member.born_date" },
        { text: "Klub", value: "club.name" },
        { text: "Kota", value: "club.city" },
        { text: "Seri", value: "series" },
        { text: "Line Number", value: "line_number" },
        { text: "Time Result", value: "best_time" },
        { text: "Hasil", value: "result" }
      ],
      event: [],
      events: [],
      matches: [],
      edit: false,
      rules: {
        required: value => !!value || "Required."
      },

      showModal: false,
      form: {},
      defaultForm: {},
      search: "",
      dialog: false,
      formHasErrors: false,
      id: 0
    };
  },
  created() {
    this.id = this.$route.params.id;
    axios.get("/api/events/showcurrent").then(response => {
      // mengirim data hasil fetch ke varibale array persons
      this.events = response.data;
      if (!(this.id > 0)) {
        this.event = this.events[this.events.length - 1];
      }
    });
    this.subscribe();
    this.loadData();
  },

  methods: {
    subscribe() {
      let pusher = new Pusher("1a76398a1c894c863949", {
        cluster: "ap1",
        forceTLS: true
      });
      pusher.subscribe("my-channel");
      pusher.bind("my-event", data => {
        this.loadData();
      });
    },
    loadData() {
      // fetch data dari api menggunakan axios

      if (this.id > 0) {
        axios.get("/api/liveresult/" + this.id).then(response => {
          this.matches = response.data;
        });
        this.event = parseInt(this.id);
      }
      this.defaultForm = {
        best_time: "00.00.00,000",
        result: ""
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
      this.form.best_time = this.timeFormat(item.best_time);
      this.form.result = item.result;
      this.form.id = item.id;
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
      this.form.int_best_time = this.timeToInt;
      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;
        this.$refs[f].validate(true);
      });

      if (!this.formHasErrors) {
        console.log(123);
        // post data ke api menggunakan axios
        if (this.edit && this.form.id > 0) {
          this.isLoading = true;
          axios
            .post("/api/events/matches/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })
            .then(response => {
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
    },
    countSeries(participants) {
      let unique = [...new Set(participants.map(item => item.series))];
      return unique;
    },
    filterRule(participants, rule_id) {
      return participants.filter(function(p) {
        return p.category_rule_id == rule_id;
      });
    },
    countParticipantRule(participants, rule_id) {
      let p = this.filterRule(participants, rule_id);
      return p.length;
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    event(val) {
      if (val.id > 0) {
        this.id = val.id;

        this.event_name = val.name;

        this.loadData();
      }
    }
  }
};
</script>