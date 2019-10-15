
(function($){$.extend(true,window,{Slick:{Data:{DataView:DataView,Aggregators:{Avg:AvgAggregator,Min:MinAggregator,Max:MaxAggregator}}}});function DataView(options){var self=this;var defaults={groupItemMetadataProvider:null};var idProperty="id";var items=[];var rows=[];var idxById={};var rowsById=null;var filter=null;var updated=null;var suspend=false;var sortAsc=true;var fastSortField;var sortComparer;var groupingGetter;var groupingGetterIsAFn;var groupingFormatter;var groupingComparer;var groups=[];var collapsedGroups={};var aggregators;var aggregateCollapsed=false;var pagesize=0;var pagenum=0;var totalRows=0;var onRowCountChanged=new Slick.Event();var onRowsChanged=new Slick.Event();var onPagingInfoChanged=new Slick.Event();options=$.extend(true,{},defaults,options);function beginUpdate(){suspend=true;}
function endUpdate(hints){suspend=false;refresh(hints);}
function updateIdxById(startingIndex){startingIndex=startingIndex||0;var id;for(var i=startingIndex,l=items.length;i<l;i++){id=items[i][idProperty];if(id===undefined){throw"Each data element must implement a unique 'id' property";}
idxById[id]=i;}}
function ensureIdUniqueness(){var id;for(var i=0,l=items.length;i<l;i++){id=items[i][idProperty];if(id===undefined||idxById[id]!==i){throw"Each data element must implement a unique 'id' property";}}}
function getItems(){return items;}
function setItems(data,objectIdProperty){if(objectIdProperty!==undefined)idProperty=objectIdProperty;items=data;idxById={};updateIdxById();ensureIdUniqueness();refresh();}
function setPagingOptions(args){if(args.pageSize!=undefined)
pagesize=args.pageSize;if(args.pageNum!=undefined)
pagenum=Math.min(args.pageNum,Math.ceil(totalRows/pagesize));onPagingInfoChanged.notify(getPagingInfo(),null,self);refresh();}
function getPagingInfo(){return{pageSize:pagesize,pageNum:pagenum,totalRows:totalRows};}
function sort(comparer,ascending){sortAsc=ascending;sortComparer=comparer;fastSortField=null;if(ascending===false)items.reverse();items.sort(comparer);if(ascending===false)items.reverse();idxById={};updateIdxById();refresh();}
function fastSort(field,ascending){sortAsc=ascending;fastSortField=field;sortComparer=null;var oldToString=Object.prototype.toString;Object.prototype.toString=(typeof field=="function")?field:function(){return this[field]};if(ascending===false)items.reverse();items.sort();Object.prototype.toString=oldToString;if(ascending===false)items.reverse();idxById={};updateIdxById();refresh();}
function reSort(){if(sortComparer){sort(sortComparer,sortAsc);}
else if(fastSortField){fastSort(fastSortField,sortAsc);}}
function setFilter(filterFn){filter=filterFn;refresh();}
function groupBy(valueGetter,valueFormatter,sortComparer){if(!options.groupItemMetadataProvider){options.groupItemMetadataProvider=new Slick.Data.GroupItemMetadataProvider();}
groupingGetter=valueGetter;groupingGetterIsAFn=typeof groupingGetter==="function";groupingFormatter=valueFormatter;groupingComparer=sortComparer;collapsedGroups={};groups=[];refresh();}
function setAggregators(groupAggregators,includeCollapsed){aggregators=groupAggregators;aggregateCollapsed=includeCollapsed!==undefined?includeCollapsed:aggregateCollapsed;refresh();}
function getItemByIdx(i){return items[i];}
function getIdxById(id){return idxById[id];}
function getRowById(id){if(!rowsById){rowsById={};for(var i=0,l=rows.length;i<l;++i){rowsById[rows[i][idProperty]]=i;}}
return rowsById[id];}
function getItemById(id){return items[idxById[id]];}
function updateItem(id,item){if(idxById[id]===undefined||id!==item[idProperty])
throw"Invalid or non-matching id";items[idxById[id]]=item;if(!updated)updated={};updated[id]=true;refresh();}
function insertItem(insertBefore,item){items.splice(insertBefore,0,item);updateIdxById(insertBefore);refresh();}
function addItem(item){items.push(item);updateIdxById(items.length-1);refresh();}
function deleteItem(id){var idx=idxById[id];if(idx===undefined){throw"Invalid id";}
delete idxById[id];items.splice(idx,1);updateIdxById(idx);refresh();}
function getLength(){return rows.length;}
function getItem(i){return rows[i];}
function getItemMetadata(i){var item=rows[i];if(item===undefined){return null;}
if(item.__group){return options.groupItemMetadataProvider.getGroupRowMetadata(item);}
if(item.__groupTotals){return options.groupItemMetadataProvider.getTotalsRowMetadata(item);}
return null;}
function collapseGroup(groupingValue){collapsedGroups[groupingValue]=true;refresh();}
function expandGroup(groupingValue){delete collapsedGroups[groupingValue];refresh();}
function getGroups(){return groups;}
function extractGroups(rows){var group;var val;var groups=[];var groupsByVal={};var r;for(var i=0,l=rows.length;i<l;i++){r=rows[i];val=(groupingGetterIsAFn)?groupingGetter(r):r[groupingGetter];group=groupsByVal[val];if(!group){group=new Slick.Group();group.count=0;group.value=val;group.rows=[];groups[groups.length]=group;groupsByVal[val]=group;}
group.rows[group.count++]=r;}
return groups;}
function calculateGroupTotals(group){var r,idx;if(group.collapsed&&!aggregateCollapsed){return;}
idx=aggregators.length;while(idx--){aggregators[idx].init();}
for(var j=0,jj=group.rows.length;j<jj;j++){r=group.rows[j];idx=aggregators.length;while(idx--){aggregators[idx].accumulate(r);}}
var t=new Slick.GroupTotals();idx=aggregators.length;while(idx--){aggregators[idx].storeResult(t);}
t.group=group;group.totals=t;}
function calculateTotals(groups){var idx=groups.length;while(idx--){calculateGroupTotals(groups[idx]);}}
function finalizeGroups(groups){var idx=groups.length,g;while(idx--){g=groups[idx];g.collapsed=(g.value in collapsedGroups);g.title=groupingFormatter?groupingFormatter(g):g.value;}}
function flattenGroupedRows(groups){var groupedRows=[],gl=0,idx,t,g,r;for(var i=0,l=groups.length;i<l;i++){g=groups[i];groupedRows[gl++]=g;if(!g.collapsed){for(var j=0,jj=g.rows.length;j<jj;j++){groupedRows[gl++]=g.rows[j];}}
if(g.totals&&(!g.collapsed||aggregateCollapsed)){groupedRows[gl++]=g.totals;}}
return groupedRows;}
function getFilteredAndPagedItems(items,filter){var pageStartRow=pagesize*pagenum;var pageEndRow=pageStartRow+pagesize;var itemIdx=0,rowIdx=0,item;var newRows=[];if(filter){for(var i=0,il=items.length;i<il;++i){item=items[i];if(!filter||filter(item)){if(!pagesize||(itemIdx>=pageStartRow&&itemIdx<pageEndRow)){newRows[rowIdx]=item;rowIdx++;}
itemIdx++;}}}
else{newRows=pagesize?items.slice(pageStartRow,pageEndRow):items.concat();itemIdx=items.length;}
return{totalRows:itemIdx,rows:newRows};}
function getRowDiffs(rows,newRows){var item,r,eitherIsNonData,diff=[];for(var i=0,rl=rows.length,nrl=newRows.length;i<nrl;i++){if(i>=rl){diff[diff.length]=i;}
else{item=newRows[i];r=rows[i];if((groupingGetter&&(eitherIsNonData=(item.__nonDataRow)||(r.__nonDataRow))&&item.__group!==r.__group||item.__updated||item.__group&&!item.equals(r))||(aggregators&&eitherIsNonData&&(item.__groupTotals||r.__groupTotals))||item[idProperty]!=r[idProperty]||(updated&&updated[item[idProperty]])){diff[diff.length]=i;}}}
return diff;}
function recalc(_items,_rows,_filter){rowsById=null;var newRows=[];var filteredItems=getFilteredAndPagedItems(_items,_filter);totalRows=filteredItems.totalRows;newRows=filteredItems.rows;groups=[];if(groupingGetter!=null){groups=extractGroups(newRows);if(groups.length){finalizeGroups(groups);if(aggregators){calculateTotals(groups);}
groups.sort(groupingComparer);newRows=flattenGroupedRows(groups);}}
var diff=getRowDiffs(_rows,newRows);rows=newRows;return diff;}
function refresh(){if(suspend)return;var countBefore=rows.length;var totalRowsBefore=totalRows;var diff=recalc(items,rows,filter);if(pagesize&&totalRows<pagenum*pagesize){pagenum=Math.floor(totalRows/pagesize);diff=recalc(items,rows,filter);}
updated=null;if(totalRowsBefore!=totalRows)onPagingInfoChanged.notify(getPagingInfo(),null,self);if(countBefore!=rows.length)onRowCountChanged.notify({previous:countBefore,current:rows.length},null,self);if(diff.length>0)onRowsChanged.notify({rows:diff},null,self);}
return{"beginUpdate":beginUpdate,"endUpdate":endUpdate,"setPagingOptions":setPagingOptions,"getPagingInfo":getPagingInfo,"getItems":getItems,"setItems":setItems,"setFilter":setFilter,"sort":sort,"fastSort":fastSort,"reSort":reSort,"groupBy":groupBy,"setAggregators":setAggregators,"collapseGroup":collapseGroup,"expandGroup":expandGroup,"getGroups":getGroups,"getIdxById":getIdxById,"getRowById":getRowById,"getItemById":getItemById,"getItemByIdx":getItemByIdx,"refresh":refresh,"updateItem":updateItem,"insertItem":insertItem,"addItem":addItem,"deleteItem":deleteItem,"getLength":getLength,"getItem":getItem,"getItemMetadata":getItemMetadata,"onRowCountChanged":onRowCountChanged,"onRowsChanged":onRowsChanged,"onPagingInfoChanged":onPagingInfoChanged};}
function AvgAggregator(field){var count;var nonNullCount;var sum;this.init=function(){count=0;nonNullCount=0;sum=0;};this.accumulate=function(item){var val=item[field];count++;if(val!=null&&val!=NaN){nonNullCount++;sum+=1*val;}};this.storeResult=function(groupTotals){if(!groupTotals.avg){groupTotals.avg={};}
if(nonNullCount!=0){groupTotals.avg[field]=sum/nonNullCount;}};}
function MinAggregator(field){var min;this.init=function(){min=null;};this.accumulate=function(item){var val=item[field];if(val!=null&&val!=NaN){if(min==null||val<min){min=val;}}};this.storeResult=function(groupTotals){if(!groupTotals.min){groupTotals.min={};}
groupTotals.min[field]=min;}}
function MaxAggregator(field){var max;this.init=function(){max=null;};this.accumulate=function(item){var val=item[field];if(val!=null&&val!=NaN){if(max==null||val>max){max=val;}}};this.storeResult=function(groupTotals){if(!groupTotals.max){groupTotals.max={};}
groupTotals.max[field]=max;}}})(jQuery);