
/*
 * 补丁管理
 */

#import "YYPatchManager.h"
#import "JPLoader.h"
#import "JPCleaner.h"
#import "JPEngine.h"

/**
 * https://github.com/bang590/JSPatch/wiki/JSPatch-Loader-使用文档
 */
@implementation YYPatchManager
+(void)run{
    @try {
        NSLog(@"开始运行补丁程序");
        [JPLoader run];
    } @catch (NSException *exception) {
        NSLog(@"补丁损坏,正在清除...");
//        [Bugly reportException:exception];
        [JPCleaner cleanAll];
        [JPLoader clearVersion];
    } @finally {
        NSString *appVersion = [[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleShortVersionString"];

        NSString *urlStr = [NSString stringWithFormat:@"%@/%@/patchVersion.json",rootUrl,appVersion]; 
        NSURL *url = [NSURL URLWithString:urlStr];
        
        NSURLRequest *req = [NSURLRequest requestWithURL:url cachePolicy:NSURLRequestReloadIgnoringLocalCacheData timeoutInterval:30];
        //https://github.com/Natoto/other/blob/082bddf6a87ead24b0a5e4ed5659b91441da4aba/hjbpatch/1.0/v13.zip?raw=true
        NSLog(@"获取补丁版本");
        NSURLSessionDataTask *dataTask = [[NSURLSession sharedSession] dataTaskWithRequest:req completionHandler:^(NSData * _Nullable data, NSURLResponse * _Nullable response, NSError * _Nullable error) {
            
            if (response != nil) {
                NSDictionary *vCong = [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingMutableContainers error:NULL];
                NSInteger   version = [vCong[@"version"] integerValue];
                NSInteger   lastVersion = [vCong[@"lastVersion"] integerValue];
                NSString    * dowloadurl = vCong[@"downloadurl"];
                NSLog(@"补丁版本:%@",vCong[@"version"]);
                if (!dowloadurl) {
                    NSLog(@"没有下载地址");
                }
                if (version != 0 && version > [JPLoader currentVersion]) {
                    NSLog(@"加载新补丁");
                    [JPLoader updateToVersion:version ex:dowloadurl callback:^(NSError *error) {
                        
                        if(error == nil){
                            NSLog(@"加载完成");
                            NSLog(@"移除旧补丁");
                            [JPCleaner cleanAll];
                            NSLog(@"准备执行");
                            BOOL ret;
                            @try {
                                ret = [JPLoader run];
                            } @catch (NSException *exception) {
//                                [Bugly reportException:exception];
                                [JPCleaner cleanAll];
                                NSLog(@"补丁损坏,回滚到上一个可用版本");
                                //如果新补丁损坏,就回滚到上个版本
                                if(lastVersion > 0){
                                    [JPLoader updateToVersion:lastVersion callback:^(NSError *error) {
                                        if (error != nil) {
//                                            [Bugly reportError:error];
                                            return;
                                        }
                                        @try {
                                            [JPLoader run];
                                        }@catch (NSException *exception) {
//                                            [Bugly reportException:exception];
                                            [JPCleaner cleanAll];
                                        }
                                    }];
                                }
                            } @finally {
                                NSLog(@"执行%@",(ret?@"成功":@"失败"));
                            }
                        }else{
//                            [Bugly reportError:error];
                        }
                    }];
                }else{
                    if (version == 0) {
                        [JPCleaner cleanAll];
                        if ([JPLoader currentVersion] >0) {
                            [JPLoader clearVersion];
                        }
                    }
                    NSLog(@"当前补丁为最新!");
                }
            }
        }];
        [dataTask resume];
    }
    
#if !DEBUG
    /*
      这里处理脚本加载后触发的异常,清除脚本,并上报到Bugly平台.
     */
    [JPEngine handleException:^(NSString *msg) {
        NSString *appVersion = [[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleShortVersionString"];
        NSInteger patchV =  [JPLoader currentVersion];
        NSString *str = [NSString stringWithFormat:@"JSPatch异常: appVersion(%@) 补丁(v%@)",appVersion,@(patchV)];
        NSException *exception = [NSException exceptionWithName:str reason:msg userInfo:nil]; 
        [JPCleaner cleanAll];
        [JPLoader clearVersion];
    }];
#endif
}
@end
