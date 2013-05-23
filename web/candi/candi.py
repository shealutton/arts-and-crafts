#!/usr/bin/python
import cherrypy
import os.path
import psycopg2
import time
import datetime

current_dir = os.path.dirname(os.path.abspath(__file__))

def connect(thread_index):
    cherrypy.thread_data.db = psycopg2.connect("dbname=time user=time host=localhost password=50eclipse")
cherrypy.engine.subscribe('start_thread', connect)

class hour(object):
    def index(self):
        avgcmel3latency = float(0.000625)
        diffs = ""
        shortlist = []
        diff_avg = []
        labels = ""
        i = 0
        c = cherrypy.thread_data.db.cursor()
        c.execute("SELECT seq, t0, t1, to_char(date, 'HH:MI:SS') FROM cme_candi WHERE date > (now() - interval '1 hour') ORDER BY seq DESC LIMIT 3600;")
        data = c.fetchall()
        c.close()
        length = len(data)
        if length > 0:
          while i < length: 			# sample every i rows of data
            shortlist.append(data[i])
            i += 6 				# 3600 points in an hour / 6 = 600, reasonable for graphing
          shortlist.reverse()
          for row in shortlist:
            diffs = diffs + str((float(row[2]) - float(row[1])) - avgcmel3latency) + ","
            labels = labels + "'" + str(row[3]) + "', "
          html = """
<html><head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Candi Cane Latency Monitor</title>
                <link rel="stylesheet" type="text/css" href="/css/candi.css" type="text/css"></link>
                <script type="application/javascript" src="/js/jquery-1.9.0.min.js"></script>
                <script type="text/javascript">
function timedRefresh(timeoutPeriod) {setTimeout("location.reload(true);",timeoutPeriod);}
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {renderTo: 'container',type: 'line',marginRight: 30,marginBottom: 30},
            credits: {enabled: false},
            title: {text: 'Candi 1 Hour Latency',x: -20},
            xAxis: {type: 'datetime',dateTimeLabelFormats: {second: '%H:%M:%S'},categories: [""" + labels + """],labels: {step: 59}},
            yAxis: {title: {text: 'Candi Latency - Average (Seconds)'},plotLines: [{value: 0,width: 1,color: '#808080'}]},
            tooltip: {formatter: function() {return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'C';}},
            legend: {enabled: false},
            series: [{name: 'Candi Latency',data: [""" + diffs + """]}]
        });
    });
});
                </script>
        </head>
        <body onload="JavaScript:timedRefresh(900000);">
            <script type="application/javascript" src="/js/highcharts/js/highcharts.js"></script>
            <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        </body></html>"""
          return html
        else:
          return "<h1>There is no current data. Please contact Support.</h1>"
    index.exposed = True
    # END 1 HOUR

class realtime(object):
    def index(self):
        diffs = ""
        labels = ""
        c = cherrypy.thread_data.db.cursor()
        c.execute('select seq from cme_candi order by seq desc limit 1')
        data = c.fetchall()
        c.close()
        max_id = str(data[0][0])

        c = cherrypy.thread_data.db.cursor()
        c.execute("select seq, t0, t1, date from cme_candi order by seq desc limit 300")
        res = c.fetchall()
        c.close()
        res.reverse()
        format = '%Y-%m-%d %H:%M:%S.%f'
        for row in res:
          latency = str((float(row[2]) - float(row[1])) - float(0.000625))
          datestring = str(row[3])
          epoch = time.mktime(time.strptime(datestring, format)) * 1000
          string = str('{"x": "' + str(epoch) + '", "y": ' + str(latency) + '}')
          #print string
          diffs = diffs + string
          if row != res[-1]:
                diffs = diffs + ','
          labels = labels + str(row[0])
        html = """
<html><head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Candi Cane Latency Monitor</title>
                <link rel="stylesheet" type="text/css" href="/css/candi.css" type="text/css"></link>
                <script type="application/javascript" src="/js/jquery-1.9.0.min.js"></script>
                <script type="text/javascript">
function timedRefresh(timeoutPeriod) {setTimeout("location.reload(true);",timeoutPeriod);}
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({ global: { useUTC: false } });
        window.max_id = """ + max_id + """,
        window.chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'spline',
                marginRight: 10,
                events: {
                    load: function() {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        setInterval(function() {
                            $.get(
                                '/candi/realtime/updates/' + window.max_id,
                                function (data, textStatus, jqXHR) {
                                    var ret = JSON.parse(data);
                                    for(i = 0; i < ret.length; i++) {
                                            var x = parseFloat(ret[i].date),
                                            y = ret[i].diff;
                                            series.addPoint([x, y], true, true);
                                            if(ret[i].id > window.max_id) {
                                               window.max_id = ret[i].id
                                            }}});
                        }, 1000);}}},
            title: { text: 'Candi Cane Jitter Monitor' },
            xAxis: { type: 'datetime', dateTimeLabelFormats: { second: '%H:%M:%S' } },
            yAxis: { title: { text: 'Current Latency - Long Run Average' }, plotLines: [{ value: 0, width: 1, color: '#808080' }] },
            tooltip: { formatter: function() { return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+ Highcharts.numberFormat(this.y, 2); } },
            credits: { enabled: false },
            legend: { enabled: false },
            exporting: { enabled: false },
            series: [{ name: 'Candi Latency Data', data: [ """ + diffs + """ ] }]
});});});
                </script></head>
        <body onload="JavaScript:timedRefresh(10800000);">
           <script type="application/javascript" src="/js/highcharts/js/highcharts.js"></script>
           <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
           <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto; color:white;">
               <h1>Beta Latency Monitor</h1>
               <p>This webapp monitors latency in real time. In its current beta form, accuracy is good to within 0.000100 seconds.</p>

               <p>The goal of the beta test is to primarily identify packet gaps/drops in addition to changes in latency. A gap will ALWAYS appear as a point at 1.0 seconds. Y-axis points at exactly 1 second are cause for inquiry. Current configuration will have outliers that are false positives with time intervals ranging between 0.000100 and 2.0 seconds, due to measurement error.</p>

<p>Shea</p>
           </div>
        </body>
</html>
"""
        return html
    index.exposed = True

    def updates(self, seq):
        json = "["
        c = cherrypy.thread_data.db.cursor()
        query = "select t0, t1, date, seq from cme_candi where seq > " + seq + " order by date asc;"
        c.execute(query)
        res = c.fetchall()
        c.close()
        # Hack for no data. If the line is down, no packets flow, so graph hangs. We don't want that. 
        # We want the graph to show all 1 seconds, to indicate that the line has a problem. This
        # hack tries to allow for race conditions between javascript and db insertion:
        #if len(res) == 0: # If no data, re-request packet
        #    time.sleep(float(.5))
        #    res = c.fetchall() # Refetch data
        #    if len(res) == 0: # If STILL no data, create fake data
        #        print "Candi Realtime: No Data Found"
        #        diff = "1"
        #        now = datetime.datetime.now()
        #        json = json + '{ "diff": ' + diff + ', "date": "' + str(now) + '", "id": ' + str(seq) + ' }]'
        #        return json
        #else:
        format = '%Y-%m-%d %H:%M:%S.%f'
        for i in res:
              diff = str((float(i[1]) - float(i[0])) - float(0.000625))
              datestring = str(i[2])
              epoch = time.mktime(time.strptime(datestring, format)) * 1000
              # json requires dbl quotes (") around items
              json = json + '{ "diff": ' + diff + ', "date": "' + str(epoch) + '", "id": ' + str(i[3]) + ' }'
              # add a comma to all items except last item
              if i != res[-1]:
                   json = json + ','
        json = json + "]"
        #print json
        return json
    updates.exposed = True

class Root:
    hour = hour()
    realtime = realtime()

    @cherrypy.expose
    def index(self):
        html = """
<html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Candi Cane Latency Monitor</title>
                <link rel="stylesheet" type="text/css" href="/css/candi.css" type="text/css"></link>
        </head>
        <body>
	<h2><a href="realtime">Real Time Latency Monitor</a></h2>
	<h2><a href="hour">Last 1 Hour View</a></h2>
        </body>
</html>"""
        return html
    index.exposed = True

application = cherrypy.Application(Root(), script_name=None, config=None)

