<html lang="en" ng-app="myApp">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
<script src="js/script_excel.js"></script>
<link rel="css/stylesheet" href="css/style_excel.css" />

<div ng-controller="PasteController" class="ng-scope">

    <angular-paste ng-model="rawPaste" ng-array="parsedPaste"/>
    <table class="table table-bordered table-striped table-condensed">
        <tbody>
        <tr ng-repeat="row in parsedPaste">
            <td ng-repeat="col in row" class="ng-scope ng-binding" style="border: 1px solid #aaa">
                {{col}}
            </td>
        </tr>
        <tr ng-show="parsedPaste.length==0">
            <td>Ctrl + V</td>
        </tr>
        </tbody>
    </table>
</div>

</html>