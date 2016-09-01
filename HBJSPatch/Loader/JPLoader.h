//
//  JSPatch.h
//  JSPatch
//
//  Created by bang on 15/11/14.
//  Copyright (c) 2015 bang. All rights reserved.
//

#import <Foundation/Foundation.h> 

//是否经过md5校验
const static int  jp_md5verify = 0;

const static NSString *rootUrl = @"https://raw.githubusercontent.com/Natoto/other/93ae4772a645109269e8643fe079813a2bbaeea2/hjbpatch";
static NSString *publicKey = @"-----BEGIN PUBLIC KEY-----\nsJM6n7wUShGu1F8V0a4rH+8uYJRyil9en6KCZwvr7AFpsVdh6IKYALQihv7uDO6BwYqbL8PjRrwJsA/R8DQgWjm8S+io70G5yruxcmFnzqz0fMWPSzwehY69Zs87nUDzjHj3nZSyNujQh+BosAml7QUWWv5Qx8fqdpRSQWMVPv0=\n-----END PUBLIC KEY-----";

typedef void (^JPUpdateCallback)(NSError *error);

typedef enum {
    JPUpdateErrorUnzipFailed = -1001,
    JPUpdateErrorVerifyFailed = -1002,
} JPUpdateError;

@interface JPLoader : NSObject
+ (BOOL)run;
+ (void)updateToVersion:(NSInteger)version callback:(JPUpdateCallback)callback;
+ (void)updateToVersion:(NSInteger)version ex:(NSString *)ex callback:(JPUpdateCallback)callback;

+ (void)runTestScriptInBundle;
+ (void)setLogger:(void(^)(NSString *log))logger;
+ (NSInteger)currentVersion;
+ (void)clearVersion;
@end