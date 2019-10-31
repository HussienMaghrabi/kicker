<template>
<div>
<div class="users col-md-4">
    <p>Users</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
     <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>
    <p>A</p>

</div>

  <div id="app">
    <div class="App">
      <div class="wrapper">
        <div class="workspace" ref="workspace"> <hr style="margin-top:30px">
        <hr style="margin-top:38px"><hr style="margin-top:39px"><hr style="margin-top:40px"><hr style="margin-top:40px"><hr style="margin-top:40px"><hr style="margin-top:40px">
        <hr style="margin-top:40px"><hr style="margin-top:40px"><hr style="margin-top:40px">
        <hr style="margin-top:40px"><hr style="margin-top:40px"><hr style="margin-top:40px">
        <hr style="margin-top:40px"><hr style="margin-top:40px"><hr style="margin-top:40px">
        <hr style="margin-top:40px">
          <FreeTransform
          
            v-for="element in elements"
            :key="element.id"
            :x="element.x"
            :y="element.y"
            :scale-x="element.scaleX"
            :scale-y="element.scaleY"
            :width="element.width"
            :height="element.height"
            :angle="element.angle"
            :offset-x="offsetX"
            :offset-y="offsetY"
            :disable-scale="element.disableScale === true"
            @update="update(element.id, $event);"
          > 
            <div class="element" :style="getElementStyles(element)"> 
              {{ element.text }}
            </div>
          </FreeTransform>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from "vue";
// import App from "./App";

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: "#app",
  template: "<App/>"
});

import FreeTransform from "vue-free-transform";

export default {
  name: "app",
  components: {
    FreeTransform
  },
  data() {
    return {
      elements: [
        {
          id: "el-1",
          x: 500,
          y: -200,
          scaleX: 1,
          scaleY: 1,
          width: 210,
          height: 50,
          angle: 0,
          classPrefix: "tr",
          styles: {
            background: "linear-gradient(135deg, #0FF0B3 0%,#036ED9 100%)"
          }
        },
        {
          id: "el-2",
          x: 21,
          y: -570,
          scaleX: 1,
          scaleY: 1,
          width: 210,
          height: 50,
          angle: 0,
          classPrefix: "tr2",
          text: "1",
          styles: {
            padding: `5px`,
            background: "linear-gradient(135deg, #fad961 0%,#f76b1c 100%)"
          }
        },
        {
          id: "el-3",
          x: 150,
          y: -400,
          scaleX: 1,
          scaleY: 1,
          width: 210,
          height: 50,
          angle: 0,
          classPrefix: "tr2",
          text: "2",
          styles: {
            padding: 5,
            width: "100%",
            height: "100%",
            background: "linear-gradient(135deg, #fad961 0%,#f76b1c 100%)"
          },
          disableScale: true
        },
        {
          id: "el-4",
          x: 300,
          y: -700,
          scaleX: 1,
          scaleY: 1,
          width: 200,
          height: 50,
          angle: 0,
          classPrefix: "tr3",
          styles: {
            background: "linear-gradient(135deg, #b1ea4d 0%,#459522 100%)"
          }
        }
      ],
      offsetX: 0,
      offsetY: 0
    };
  },
  mounted() {
    this.offsetX = this.$refs.workspace.offsetLeft;
    this.offsetY = this.$refs.workspace.offsetTop;
  },
  methods: {
    update(id, payload) {
      this.elements = this.elements.map(item => {
        if (item.id === id) {
          return {
            ...item,
            ...payload
          };
        }
        return item;
      });
    },
    getElementStyles(element) {
      const styles = element.styles ? element.styles : {};
      return {
        width: `${element.width}px`,
        height: `${element.height}px`,
        ...styles
      };
    }
  }
};
</script>

<style>
#app {
  display: flex;
  background: #f8fafc;
}

.wrapper {
  flex: 1;
}

.workspace {
  width: 800px;
  height: 800px;
  margin: 25px auto;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background: #fff;
}

* {
  box-sizing: border-box;
}

.tr-transform__content {
  user-select: none;
}

.tr-transform__rotator {
  top: -45px;
  left: calc(50% - 7px);
}

.tr-transform__rotator,
.tr-transform__scale-point {
  background: #fff;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  position: absolute;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.tr-transform__rotator:hover,
.tr-transform__scale-point:hover {
  background: #f1f5f8;
}

.tr-transform__rotator:active,
.tr-transform__scale-point:active {
  background: #dae1e7;
}

.tr-transform__scale-point {
}

.tr-transform__scale-point--tl {
  top: -7px;
  left: -7px;
}

.tr-transform__scale-point--ml {
  top: calc(50% - 7px);
  left: -7px;
}

.tr-transform__scale-point--tr {
  left: calc(100% - 7px);
  top: -7px;
}

.tr-transform__scale-point--tm {
  left: calc(50% - 7px);
  top: -7px;
}

.tr-transform__scale-point--mr {
  left: calc(100% - 7px);
  top: calc(50% - 7px);
}

.tr-transform__scale-point--bl {
  left: -7px;
  top: calc(100% - 7px);
}

.tr-transform__scale-point--bm {
  left: calc(50% - 7px);
  top: calc(100% - 7px);
}

.tr-transform__scale-point--br {
  left: calc(100% - 7px);
  top: calc(100% - 7px);
}
.users
{
    background-color:#dcdcdc;
    width: 9%;
    margin: 20px;
    color: black;
    padding: 5px;
    display: inline-block;
    box-shadow:  2px  2px  gray;
    border: 1px solid #dcdcdc;
    text-align: center

}
.users p 
{
    border-bottom: solid 1px gray
}
.workspace {
    position: absolute;
    top: 68px;
    width: 981px;
    right: 28.2%;
    height: 716px;
}
hr
{
    color: gray
}
</style>
