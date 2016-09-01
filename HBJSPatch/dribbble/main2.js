autoConvertOCType(1)
include('CommonDefine.js')
include('DBDataSource.js')
include('DBTimelineController.js')

defineClass('RootViewController', {
            showController: function() {
            var tableViewCtrl = WBTimelineViewController.alloc().init()
            self.navigationController().pushViewController_animated(tableViewCtrl, NO);
            //    var navCtrl = require('UINavigationController').alloc().initWithRootViewController(tableViewCtrl);
            //    self.window().setRootViewController(navCtrl);
            }
            })
