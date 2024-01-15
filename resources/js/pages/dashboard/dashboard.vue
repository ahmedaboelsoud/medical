<template>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue-madison">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                         {{ doctors }}
                    </div>
                    <div class="desc">
                      doctors
                    </div>
                </div>
                <a class="more" href="javascript:;">
                View more <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-intense">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                         12,5M$
                    </div>
                    <div class="desc">
                         Total Profit
                    </div>
                </div>
                <a class="more" href="javascript:;">
                View more <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green-haze">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                         549
                    </div>
                    <div class="desc">
                         New Orders
                    </div>
                </div>
                <a class="more" href="javascript:;">
                View more <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat purple-plum">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                         +89%
                    </div>
                    <div class="desc">
                         Brand Popularity
                    </div>
                </div>
                <a class="more" href="javascript:;">
                View more <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>

    <CanvasJSChart :options="options" :style="styleOptions" @chart-ref="chartInstance"/>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      doctors:500,
      cardInfo:[],
      chart: null,
      options: {
        animationEnabled: true,
        exportEnabled: true,
        title:{
          text: "Revenue by Number of New Customers"
        },
        axisY: {
          maximum: '',
          titleFontColor: "#47acb1",
          labelFontColor: "#47acb1",
          lineColor: "#47acb1",
          tickColor: "#47acb1",
          gridColor: "#d3d3d3"
        },
        axisY2: {
          maximum: '',
          title: "Revenue",
          valueFormatString: "$#,##0.##",
          titleFontColor: "#f07113",
          labelFontColor: "#f07113",
          lineColor: "#f07113",
          tickColor: "#f07113"
        },
        toolTip: {
          shared: true
        },
        data: [{
          type: "column",
          name: "No of New Customers",
          color: "#47acb1",
          dataPoints:[]
        },]
      },
      styleOptions: {
        width: "100%",
        height: "360px"
      }
    }
  },
  created(){
    this.loaditems();
  },
  methods: {
   loaditems(){
      axios.get('/api/dashboard')
        .then(response => {
          response.data.data.profits.forEach(element => {
             //this.options.data[0].dataPoints.push({ label: element.month, y: element.price });
             this.cardInfo.push({ label: element.month, y: parseInt(element.price) });
          });
          this.options.axisY.maximum =  parseInt(response.data.data.maxprice.price) + parseInt(response.data.data.maxprice.price / 2)
          this.getJsonItem();
        })
        .catch(error => {
          console.log(error)
      })
    },

    getJsonItem(){
      this.cardInfo.forEach(element => {
        this.options.data[0].dataPoints.push({ label: element.label, y: element.y });
    });
    
  },
    chartInstance(chart) {
      this.chart = chart;
    },
  }
}
</script>