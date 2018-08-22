/**
 * Created by jnordling on 12/13/14.
 */
/* global define */
define([
        "dojo/Deferred",
    "leaflet",
    "esrileaflet"
    ], 
    function(
        Deferred
    ) {

    var exports = {};
    var Tasks = L.esri.Tasks;
    var Query = Tasks.query;

    exports.serviceInfo = function(url){
        var deferred = new Deferred();

        Tasks.Task.request(
            url, 
            {'f':'json'},
            function(result){
                deferred.resolve(result);
            }
        );

        return deferred;
    }

    exports.uniqueFields = function(url,field,where,groupBy){
        var deferred = new Deferred();
        L.esri.get(
            url + '/query',
            {
                'f':'json',
                'outFields': [field],
                'where': where || "1=1",
                'outStatistics': [{
                    "statisticType": "count",
                    "onStatisticField": field, 
                    "outStatisticFieldName": field+"count"
                  }],
                'groupByFieldsForStatistics': groupBy.join(',')
            },
            function(error, response){
                if (error){
                    deferred.resolve(error);
                }
                else{
                    var values = _.pluck(response.features,'attributes');
                    deferred.resolve(values);
                }
            }
        );
                return deferred;
    }

    exports.getQueryString = function(fieldQueryArray){
        //hack for application because it needs to be nested in an AND
        var exceptionList = ['use_advocacy', 'use_org_opt', 'use_other', 'use_prod_srvc', 'use_research']
        var exceptionSQL = [];
        var queryStrings = [];

            _.forEach(fieldQueryArray, function(query){

            if(_.contains(exceptionList, query.fieldName)){
                var value = query.valueType === 'number' ? query.value : "'{}'".replace('{}',query.value);
                var sql = [query.fieldName,query.operator,query.value].join(' ');
                exceptionSQL.push(sql);
            } else {
                var value = query.valueType === 'number' ? query.value : "'{}'".replace('{}',query.value);
                var sql = [query.fieldName,query.operator,query.value].join(' ');
                queryStrings.push(sql);
            }

        });

        if(exceptionSQL.length>0){
            queryStrings.push("("+exceptionSQL.join(' OR ')+")");
        }
        return queryStrings.join(' AND ');

    }

    exports.features = function(url,params) {
        var deferred = new Deferred();
        var query = Query({url:url})

        _.keys(params).forEach(function(key){
            query[key](params[key]);
        });

        query.run(function(error,featureCollection,response){
            deferred.resolve(featureCollection);

        });

        return deferred;
    }

    return exports;
});