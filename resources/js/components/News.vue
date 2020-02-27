<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    News
                    <v-spacer></v-spacer>
                </v-card-title>
  <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
        <div>
      <button :class="{ 'is-active': isActive.bold() }" @click="commands.bold">
        Bold
      </button>
      <button :class="{ 'is-active': isActive.heading({ level: 2 }) }" @click="commands.heading({ level: 2 })">
        H2
      </button>
    </div>
    </editor-menu-bar>
    <editor-content :editor="editor" />
            </div>
        </div>
             
    </div>
</template>

<!-- script js -->
<script>
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History
} from "tiptap-extensions";
export default {
  components: {
    EditorContent,
    EditorMenuBar
  },
  data() {
    return {
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new HorizontalRule(),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Code(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History()
        ],
        content: `
          <h2>
            Hi there,
          </h2>
          <p>
            this is a very <em>basic</em> example of tiptap.
          </p>
          <pre><code>body { display: none; }</code></pre>
          <ul>
            <li>
              A regular list
            </li>
            <li>
              With regular items
            </li>
          </ul>
          <blockquote>
            It's amazing 👏
            <br />
            – mom
          </blockquote>
        `
      })
    };
  },
  mounted() {},
  beforeDestroy() {
    this.editor.destroy();
  }
};
</script>