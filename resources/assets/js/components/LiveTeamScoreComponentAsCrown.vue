<template>
  <div>
    <b-row>
      <b-col>
        <div class="nfl-schedules">
          <nfl-schedule-component></nfl-schedule-component>
        </div>
        <div class="d-flex d-just-content-center space-bottom">
          <div class="table-view-container space-right">
          &nbsp;
          </div>
          <div class="table-view-container table-view-label">
            <live-player-score-post-component
              :seasonData="seasondetails[0]"
              :place="1">
            </live-player-score-post-component>
            <div class="table-name-label blue-bg yellow-text">Crown Jewel</div>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <div class="d-flex d-just-content-center space-bottom">
          <div class="table-view-container space-right">
          &nbsp;
          </div>
          <div class="table-view-container  space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[1]"
              :place="2">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container table-view-label">
            <live-player-score-post-component
              :seasonData="seasondetails[2]"
              :place="3">
            </live-player-score-post-component>
            <div class="table-name-label yellow-bg red-text">Ruby Row</div>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <div class="d-flex d-just-content-start space-bottom">
          <div class="table-view-container  space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[3]"
              :place="4">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[4]"
              :place="5">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[5]"
              :place="6">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container table-view-label">
            <live-player-score-post-component
              :seasonData="seasondetails[6]"
              :place="7">
            </live-player-score-post-component>
            <div class="table-name-label crest-bg blue-text">The Crest</div>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <div class="d-flex d-just-content-center space-bottom">
          <div class="table-view-container space-right">
            &nbsp;
          </div>
          <div class="table-view-container space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[7]"
              :place="8">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[8]"
              :place="9">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container table-view-label">
            <live-player-score-post-component
              :seasonData="seasondetails[9]"
              :place="10">
            </live-player-score-post-component>
            <div class="table-name-label light-yellow-bg brown-text">Headband</div>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <div class="d-flex d-just-content-start space-bottom">
          <div class="table-view-container space-right">
          &nbsp;
          </div>
          <div class="table-view-container space-right">
            <live-player-score-post-component
              :seasonData="seasondetails[10]"
              :place="11">
            </live-player-score-post-component>
          </div>
          <div class="table-view-container table-view-label">
            <live-player-score-post-component
              :seasonData="seasondetails[11]"
              :place="12">
            </live-player-score-post-component>
            <div class="table-name-label black-bg white-text">Sweatband</div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<style>
  .table-view-container{max-width:500px;min-width:500px; width:100%;font-family: "Arial", "sans-serif";}
  .table-view{width:100%; font-family: "Arial", "sans-serif";   line-height: 100%;box-sizing: border-box; }
  .table-view-head div{font-size:16px;}
  .table-view-head{display: flex; align-items: center;}
  .table-head--left{width:calc((100% / 3) - 8px); }
  .table-head--right, .table--data {width:calc(100% / 1); }
  .cell-space{padding:8px 5px; }
  .b-top{border-top:1px solid #000;}
  .b-bottom{border-bottom:1px solid #000;}
  .b-left{border-left:1px solid #000;}
  .b-right{border-right:1px solid #000;}
  .table-view--content{border:1px solid #000;}
/*  .table-data--container{display: flex;align-items: stretch;}*/
  .txt-uppercase{text-transform: uppercase;}
  .brown-bg{background-color:#993400; }
  .blue-bg{background-color:#0166cc; }
  .red-bg{background-color:#ff0000; }
  .light-blue-bg{background-color:#32cccc; }
  .light-yellow-bg{background-color:#f3f300; }
  .yellow-bg{background-color:#FBD200; }
  .lavender-bg{background-color:#800080; }
  .green-bg{background-color:#008000; }
  .crest-bg{background-color:#6eda0e; }
  .black-bg{background-color:#000; }
  .black-text{color:#000; }
  .brown-text{color:#993400; }
  .white-text{color:#fff; }
  .yellow-text{color:#FBD200; }
  .blue-text{color:#0166cc; }
  .red-text{color:#ff0000; }
  .table-data--bottom{}
  .font-13{font-size:13px; }
  .font-16{font-size:16px; }
  .font-bold{font-weight: 600;}
  .txt-left{text-align:left;}
  .txt-right{text-align: right;}
  .table--result{display: flex; align-items: center; justify-content: flex-end;}
  .table-footer--data{width:calc(100% / 2);}
  .table-result--container{width: calc((100% - -1px) / 2);}
  .table-view--footer{display: flex; align-items: center; justify-content: flex-end;}
  .table-name-label{position: absolute;top: 50%;margin-top: -30px;right: -150px;padding: 20px 10px;font-size: 18px;width: 150px;box-sizing: border-box;text-align: center;}
  .table-view-label{position: relative;}
  .color-container{max-width:500px; font-family: "Arial", "sans-serif";width:100%;}
  .d-flex{display: flex;}
  .d-align-center{align-items: center;}
  .d-just-content-center{justify-content: center;}
  .d-just-content-start{justify-content: flex-start;}
  .color-width{width: calc(100% / 3)}
  .color-data, .color-data-head{padding: 8px 5px;}
  .txt-center{text-align: center;}
  .color-content-container{line-height:100%;font-weight: 600; }
  .space-right{margin-right:30px; }
  .space-bottom{margin-bottom:30px; }
  .nfl-schedules{position: absolute;}
</style>

<script>

export default {
  props:{
      seasondetails: { type: Array, required: false },
  }
}

</script>
