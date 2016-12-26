<template>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{title}}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th v-for="colu in gridColumns">{{colu}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in gridData">
                                <td v-for="key in gridColumns">
                                    {{item[key]}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</template>

<script type="text/javascript">
    
    export default {
        name : "admin_table",
        props : [
            'gridColumns',
            'gridData',
            'title'
        ]
    }
</script>
