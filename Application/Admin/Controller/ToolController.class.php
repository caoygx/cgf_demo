<?php
namespace Admin\Controller;

use Common\CommonController;

/**
 * 后台脚本
 * Class ToolController
 * @package Admin\Controller
 */
class ToolController extends CommonController
{
    function setNickname(){
        $mUser = M('User');
        $r = $mUser->where("nickname='' and username is null")->select();
        echo   $mUser->getLastSql();exit('x');
        echo '111';exit('x');
    }

    /**
     * 更新视频信息
     */
    function updateVideoInfo(){
        $m = M('Video');

        $where = [];
        //$where['duration']=0;
        $where['upload_status'] = ['gt',1];
        $r = $m->where($where)->select();
        $vod = new \Common\Aliyunvod();
        foreach ($r as $k => $v) {
            $info = $vod->getVideoInfo($v['video_id']);
            $data = [];
            if($r['duration'] != $info->Duration)  $data['duration'] = $info->Duration;
            if($r['cover'] != $info->CoverURL) $data['cover'] = $info->CoverURL;
            if($info->Status=='Normal' && $r['upload_status'] <3 ) $data['upload_status'] = 3;
            $m->where(['id'=>$v['id']])->save($data);
            echo $m->getLastSql();
            echo LF;
        }
    }

    function batGenerateUser(){




// generate data by accessing properties

        $mUser = D('User');
        $sql = "SELECT max(id) as maxId FROM `user` WHERE id <30000";
        $r = $mUser->query($sql);
        $maxId = $r[0]['maxId'];

        $generateSum = I('generateSum',5);
        //$generateSum = 5;
        $startId = $maxId+1;
        $endId = $startId+$generateSum;
        for($id = $startId; $id < $endId; $id++){
            $userinfo = [];
            $userinfo['id'] = $id;
            $userinfo['username'] = "fake_".$id;
            $userinfo['type'] = 9;
            $userinfo['nickname'] = self::randNickname();
            //var_dump($userinfo);
            $mUser->msave($userinfo);
        }


    }

    static function randNickname(){

        $cn = mt_rand(0,1);
        if($cn){ //中文名

            //国标一级汉字（3755个，按拼音排序）
            $han = '啊阿埃挨哎唉哀皑癌蔼矮艾碍爱隘鞍氨安俺按暗岸胺案肮昂盎凹敖熬翱袄傲奥懊澳芭捌扒叭吧笆八疤巴拔跋靶把耙坝霸罢爸白柏百摆佰败拜稗斑班搬扳般颁板版扮拌伴瓣半办绊邦帮梆榜膀绑棒磅蚌镑傍谤苞胞包褒剥薄雹保堡饱宝抱报暴豹鲍爆杯碑悲卑北辈背贝钡倍狈备惫焙被奔苯本笨崩绷甭泵蹦迸逼鼻比鄙笔彼碧蓖蔽毕毙毖币庇痹闭敝弊必辟壁臂避陛鞭边编贬扁便变卞辨辩辫遍标彪膘表鳖憋别瘪彬斌濒滨宾摈兵冰柄丙秉饼炳病并玻菠播拨钵波博勃搏铂箔伯帛舶脖膊渤泊驳捕卜哺补埠不布步簿部怖擦猜裁材才财睬踩采彩菜蔡餐参蚕残惭惨灿苍舱仓沧藏操糙槽曹草厕策侧册测层蹭插叉茬茶查碴搽察岔差诧拆柴豺搀掺蝉馋谗缠铲产阐颤昌猖场尝常长偿肠厂敞畅唱倡超抄钞朝嘲潮巢吵炒车扯撤掣彻澈郴臣辰尘晨忱沉陈趁衬撑称城橙成呈乘程惩澄诚承逞骋秤吃痴持匙池迟弛驰耻齿侈尺赤翅斥炽充冲虫崇宠抽酬畴踌稠愁筹仇绸瞅丑臭初出橱厨躇锄雏滁除楚础储矗搐触处揣川穿椽传船喘串疮窗幢床闯创吹炊捶锤垂春椿醇唇淳纯蠢戳绰疵茨磁雌辞慈瓷词此刺赐次聪葱囱匆从丛凑粗醋簇促蹿篡窜摧崔催脆瘁粹淬翠村存寸磋撮搓措挫错搭达答瘩打大呆歹傣戴带殆代贷袋待逮怠耽担丹单郸掸胆旦氮但惮淡诞弹蛋当挡党荡档刀捣蹈倒岛祷导到稻悼道盗德得的蹬灯登等瞪凳邓堤低滴迪敌笛狄涤翟嫡抵底地蒂第帝弟递缔颠掂滇碘点典靛垫电佃甸店惦奠淀殿碉叼雕凋刁掉吊钓调跌爹碟蝶迭谍叠丁盯叮钉顶鼎锭定订丢东冬董懂动栋侗恫冻洞兜抖斗陡豆逗痘都督毒犊独读堵睹赌杜镀肚度渡妒端短锻段断缎堆兑队对墩吨蹲敦顿囤钝盾遁掇哆多夺垛躲朵跺舵剁惰堕蛾峨鹅俄额讹娥恶厄扼遏鄂饿恩而儿耳尔饵洱二贰发罚筏伐乏阀法珐藩帆番翻樊矾钒繁凡烦反返范贩犯饭泛坊芳方肪房防妨仿访纺放菲非啡飞肥匪诽吠肺废沸费芬酚吩氛分纷坟焚汾粉奋份忿愤粪丰封枫蜂峰锋风疯烽逢冯缝讽奉凤佛否夫敷肤孵扶拂辐幅氟符伏俘服浮涪福袱弗甫抚辅俯釜斧脯腑府腐赴副覆赋复傅付阜父腹负富讣附妇缚咐噶嘎该改概钙盖溉干甘杆柑竿肝赶感秆敢赣冈刚钢缸肛纲岗港杠篙皋高膏羔糕搞镐稿告哥歌搁戈鸽胳疙割革葛格蛤阁隔铬个各给根跟耕更庚羹埂耿梗工攻功恭龚供躬公宫弓巩汞拱贡共钩勾沟苟狗垢构购够辜菇咕箍估沽孤姑鼓古蛊骨谷股故顾固雇刮瓜剐寡挂褂乖拐怪棺关官冠观管馆罐惯灌贯光广逛瑰规圭硅归龟闺轨鬼诡癸桂柜跪贵刽辊滚棍锅郭国果裹过哈骸孩海氦亥害骇酣憨邯韩含涵寒函喊罕翰撼捍旱憾悍焊汗汉夯杭航壕嚎豪毫郝好耗号浩呵喝荷菏核禾和何合盒貉阂河涸赫褐鹤贺嘿黑痕很狠恨哼亨横衡恒轰哄烘虹鸿洪宏弘红喉侯猴吼厚候后呼乎忽瑚壶葫胡蝴狐糊湖弧虎唬护互沪户花哗华猾滑画划化话槐徊怀淮坏欢环桓还缓换患唤痪豢焕涣宦幻荒慌黄磺蝗簧皇凰惶煌晃幌恍谎灰挥辉徽恢蛔回毁悔慧卉惠晦贿秽会烩汇讳诲绘荤昏婚魂浑混豁活伙火获或惑霍货祸击圾基机畸稽积箕肌饥迹激讥鸡姬绩缉吉极棘辑籍集及急疾汲即嫉级挤几脊己蓟技冀季伎祭剂悸济寄寂计记既忌际妓继纪嘉枷夹佳家加荚颊贾甲钾假稼价架驾嫁歼监坚尖笺间煎兼肩艰奸缄茧检柬碱硷拣捡简俭剪减荐槛鉴践贱见键箭件健舰剑饯渐溅涧建僵姜将浆江疆蒋桨奖讲匠酱降蕉椒礁焦胶交郊浇骄娇嚼搅铰矫侥脚狡角饺缴绞剿教酵轿较叫窖揭接皆秸街阶截劫节桔杰捷睫竭洁结解姐戒藉芥界借介疥诫届巾筋斤金今津襟紧锦仅谨进靳晋禁近烬浸尽劲荆兢茎睛晶鲸京惊精粳经井警景颈静境敬镜径痉靖竟竞净炯窘揪究纠玖韭久灸九酒厩救旧臼舅咎就疚鞠拘狙疽居驹菊局咀矩举沮聚拒据巨具距踞锯俱句惧炬剧捐鹃娟倦眷卷绢撅攫抉掘倔爵觉决诀绝均菌钧军君峻俊竣浚郡骏喀咖卡咯开揩楷凯慨刊堪勘坎砍看康慷糠扛抗亢炕考拷烤靠坷苛柯棵磕颗科壳咳可渴克刻客课肯啃垦恳坑吭空恐孔控抠口扣寇枯哭窟苦酷库裤夸垮挎跨胯块筷侩快宽款匡筐狂框矿眶旷况亏盔岿窥葵奎魁傀馈愧溃坤昆捆困括扩廓阔垃拉喇蜡腊辣啦莱来赖蓝婪栏拦篮阑兰澜谰揽览懒缆烂滥琅榔狼廊郎朗浪捞劳牢老佬姥酪烙涝勒乐雷镭蕾磊累儡垒擂肋类泪棱楞冷厘梨犁黎篱狸离漓理李里鲤礼莉荔吏栗丽厉励砾历利傈例俐痢立粒沥隶力璃哩俩联莲连镰廉怜涟帘敛脸链恋炼练粮凉梁粱良两辆量晾亮谅撩聊僚疗燎寥辽潦了撂镣廖料列裂烈劣猎琳林磷霖临邻鳞淋凛赁吝拎玲菱零龄铃伶羚凌灵陵岭领另令溜琉榴硫馏留刘瘤流柳六龙聋咙笼窿隆垄拢陇楼娄搂篓漏陋芦卢颅庐炉掳卤虏鲁麓碌露路赂鹿潞禄录陆戮驴吕铝侣旅履屡缕虑氯律率滤绿峦挛孪滦卵乱掠略抡轮伦仑沦纶论萝螺罗逻锣箩骡裸落洛骆络妈麻玛码蚂马骂嘛吗埋买麦卖迈脉瞒馒蛮满蔓曼慢漫谩芒茫盲氓忙莽猫茅锚毛矛铆卯茂冒帽貌贸么玫枚梅酶霉煤没眉媒镁每美昧寐妹媚门闷们萌蒙檬盟锰猛梦孟眯醚靡糜迷谜弥米秘觅泌蜜密幂棉眠绵冕免勉娩缅面苗描瞄藐秒渺庙妙蔑灭民抿皿敏悯闽明螟鸣铭名命谬摸摹蘑模膜磨摩魔抹末莫墨默沫漠寞陌谋牟某拇牡亩姆母墓暮幕募慕木目睦牧穆拿哪呐钠那娜纳氖乃奶耐奈南男难囊挠脑恼闹淖呢馁内嫩能妮霓倪泥尼拟你匿腻逆溺蔫拈年碾撵捻念娘酿鸟尿捏聂孽啮镊镍涅您柠狞凝宁拧泞牛扭钮纽脓浓农弄奴努怒女暖虐疟挪懦糯诺哦欧鸥殴藕呕偶沤啪趴爬帕怕琶拍排牌徘湃派攀潘盘磐盼畔判叛乓庞旁耪胖抛咆刨炮袍跑泡呸胚培裴赔陪配佩沛喷盆砰抨烹澎彭蓬棚硼篷膨朋鹏捧碰坯砒霹批披劈琵毗啤脾疲皮匹痞僻屁譬篇偏片骗飘漂瓢票撇瞥拼频贫品聘乒坪苹萍平凭瓶评屏坡泼颇婆破魄迫粕剖扑铺仆莆葡菩蒲埔朴圃普浦谱曝瀑期欺栖戚妻七凄漆柒沏其棋奇歧畦崎脐齐旗祈祁骑起岂乞企启契砌器气迄弃汽泣讫掐恰洽牵扦钎铅千迁签仟谦乾黔钱钳前潜遣浅谴堑嵌欠歉枪呛腔羌墙蔷强抢橇锹敲悄桥瞧乔侨巧鞘撬翘峭俏窍切茄且怯窃钦侵亲秦琴勤芹擒禽寝沁青轻氢倾卿清擎晴氰情顷请庆琼穷秋丘邱球求囚酋泅趋区蛆曲躯屈驱渠取娶龋趣去圈颧权醛泉全痊拳犬券劝缺炔瘸却鹊榷确雀裙群然燃冉染瓤壤攘嚷让饶扰绕惹热壬仁人忍韧任认刃妊纫扔仍日戎茸蓉荣融熔溶容绒冗揉柔肉茹蠕儒孺如辱乳汝入褥软阮蕊瑞锐闰润若弱撒洒萨腮鳃塞赛三叁伞散桑嗓丧搔骚扫嫂瑟色涩森僧莎砂杀刹沙纱傻啥煞筛晒珊苫杉山删煽衫闪陕擅赡膳善汕扇缮墒伤商赏晌上尚裳梢捎稍烧芍勺韶少哨邵绍奢赊蛇舌舍赦摄射慑涉社设砷申呻伸身深娠绅神沈审婶甚肾慎渗声生甥牲升绳省盛剩胜圣师失狮施湿诗尸虱十石拾时什食蚀实识史矢使屎驶始式示士世柿事拭誓逝势是嗜噬适仕侍释饰氏市恃室视试收手首守寿授售受瘦兽蔬枢梳殊抒输叔舒淑疏书赎孰熟薯暑曙署蜀黍鼠属术述树束戍竖墅庶数漱恕刷耍摔衰甩帅栓拴霜双爽谁水睡税吮瞬顺舜说硕朔烁斯撕嘶思私司丝死肆寺嗣四伺似饲巳松耸怂颂送宋讼诵搜艘擞嗽苏酥俗素速粟僳塑溯宿诉肃酸蒜算虽隋随绥髓碎岁穗遂隧祟孙损笋蓑梭唆缩琐索锁所塌他它她塔獭挞蹋踏胎苔抬台泰酞太态汰坍摊贪瘫滩坛檀痰潭谭谈坦毯袒碳探叹炭汤塘搪堂棠膛唐糖倘躺淌趟烫掏涛滔绦萄桃逃淘陶讨套特藤腾疼誊梯剔踢锑提题蹄啼体替嚏惕涕剃屉天添填田甜恬舔腆挑条迢眺跳贴铁帖厅听烃汀廷停亭庭挺艇通桐酮瞳同铜彤童桶捅筒统痛偷投头透凸秃突图徒途涂屠土吐兔湍团推颓腿蜕褪退吞屯臀拖托脱鸵陀驮驼椭妥拓唾挖哇蛙洼娃瓦袜歪外豌弯湾玩顽丸烷完碗挽晚皖惋宛婉万腕汪王亡枉网往旺望忘妄威巍微危韦违桅围唯惟为潍维苇萎委伟伪尾纬未蔚味畏胃喂魏位渭谓尉慰卫瘟温蚊文闻纹吻稳紊问嗡翁瓮挝蜗涡窝我斡卧握沃巫呜钨乌污诬屋无芜梧吾吴毋武五捂午舞伍侮坞戊雾晤物勿务悟误昔熙析西硒矽晰嘻吸锡牺稀息希悉膝夕惜熄烯溪汐犀檄袭席习媳喜铣洗系隙戏细瞎虾匣霞辖暇峡侠狭下厦夏吓掀锨先仙鲜纤咸贤衔舷闲涎弦嫌显险现献县腺馅羡宪陷限线相厢镶香箱襄湘乡翔祥详想响享项巷橡像向象萧硝霄削哮嚣销消宵淆晓小孝校肖啸笑效楔些歇蝎鞋协挟携邪斜胁谐写械卸蟹懈泄泻谢屑薪芯锌欣辛新忻心信衅星腥猩惺兴刑型形邢行醒幸杏性姓兄凶胸匈汹雄熊休修羞朽嗅锈秀袖绣墟戌需虚嘘须徐许蓄酗叙旭序畜恤絮婿绪续轩喧宣悬旋玄选癣眩绚靴薛学穴雪血勋熏循旬询寻驯巡殉汛训讯逊迅压押鸦鸭呀丫芽牙蚜崖衙涯雅哑亚讶焉咽阉烟淹盐严研蜒岩延言颜阎炎沿奄掩眼衍演艳堰燕厌砚雁唁彦焰宴谚验殃央鸯秧杨扬佯疡羊洋阳氧仰痒养样漾邀腰妖瑶摇尧遥窑谣姚咬舀药要耀椰噎耶爷野冶也页掖业叶曳腋夜液一壹医揖铱依伊衣颐夷遗移仪胰疑沂宜姨彝椅蚁倚已乙矣以艺抑易邑屹亿役臆逸肄疫亦裔意毅忆义益溢诣议谊译异翼翌绎茵荫因殷音阴姻吟银淫寅饮尹引隐印英樱婴鹰应缨莹萤营荧蝇迎赢盈影颖硬映哟拥佣臃痈庸雍踊蛹咏泳涌永恿勇用幽优悠忧尤由邮铀犹油游酉有友右佑釉诱又幼迂淤于盂榆虞愚舆余俞逾鱼愉渝渔隅予娱雨与屿禹宇语羽玉域芋郁吁遇喻峪御愈欲狱育誉浴寓裕预豫驭鸳渊冤元垣袁原援辕园员圆猿源缘远苑愿怨院曰约越跃钥岳粤月悦阅耘云郧匀陨允运蕴酝晕韵孕匝砸杂栽哉灾宰载再在咱攒暂赞赃脏葬遭糟凿藻枣早澡蚤躁噪造皂灶燥责择则泽贼怎增憎曾赠扎喳渣札轧铡闸眨栅榨咋乍炸诈摘斋宅窄债寨瞻毡詹粘沾盏斩辗崭展蘸栈占战站湛绽樟章彰漳张掌涨杖丈帐账仗胀瘴障招昭找沼赵照罩兆肇召遮折哲蛰辙者锗蔗这浙珍斟真甄砧臻贞针侦枕疹诊震振镇阵蒸挣睁征狰争怔整拯正政帧症郑证芝枝支吱蜘知肢脂汁之织职直植殖执值侄址指止趾只旨纸志挚掷至致置帜峙制智秩稚质炙痔滞治窒中盅忠钟衷终种肿重仲众舟周州洲诌粥轴肘帚咒皱宙昼骤珠株蛛朱猪诸诛逐竹烛煮拄瞩嘱主著柱助蛀贮铸筑住注祝驻抓爪拽专砖转撰赚篆桩庄装妆撞壮状椎锥追赘坠缀谆准捉拙卓桌琢茁酌啄着灼浊兹咨资姿滋淄孜紫仔籽滓子自渍字鬃棕踪宗综总纵邹走奏揍租足卒族祖诅阻组钻纂嘴醉最罪尊遵昨左佐柞做作坐座
';
            $nicheng_tou=array('快乐','冷静','醉熏','潇洒','糊涂','积极','冷酷','深情','粗暴','温柔','可爱','愉快','义气','认真','威武','帅气','传统','潇洒','漂亮','自然','专一','听话','昏睡','狂野','等待','搞怪','幽默','魁梧','活泼','开心','高兴','超帅','留胡子','坦率','直率','轻松','痴情','完美','精明','无聊','有魅力','丰富','繁荣','饱满','炙热','暴躁','碧蓝','俊逸','英勇','健忘','故意','无心','土豪','朴实','兴奋','幸福','淡定','不安','阔达','孤独','独特','疯狂','时尚','落后','风趣','忧伤','大胆','爱笑','矮小','健康','合适','玩命','沉默','斯文','香蕉','苹果','鲤鱼','鳗鱼','任性','细心','粗心','大意','甜甜','酷酷','健壮','英俊','霸气','阳光','默默','大力','孝顺','忧虑','着急','紧张','善良','凶狠','害怕','重要','危机','欢喜','欣慰','满意','跳跃','诚心','称心','如意','怡然','娇气','无奈','无语','激动','愤怒','美好','感动','激情','激昂','震动','虚拟','超级','寒冷','精明','明理','犹豫','忧郁','寂寞','奋斗','勤奋','现代','过时','稳重','热情','含蓄','开放','无辜','多情','纯真','拉长','热心','从容','体贴','风中','曾经','追寻','儒雅','优雅','开朗','外向','内向','清爽','文艺','长情','平常','单身','伶俐','高大','懦弱','柔弱','爱笑','乐观','耍酷','酷炫','神勇','年轻','唠叨','瘦瘦','无情','包容','顺心','畅快','舒适','靓丽','负责','背后','简单','谦让','彩色','缥缈','欢呼','生动','复杂','慈祥','仁爱','魔幻','虚幻','淡然','受伤','雪白','高高','糟糕','顺利','闪闪','羞涩','缓慢','迅速','优秀','聪明','含糊','俏皮','淡淡','坚强','平淡','欣喜','能干','灵巧','友好','机智','机灵','正直','谨慎','俭朴','殷勤','虚心','辛勤','自觉','无私','无限','踏实','老实','现实','可靠','务实','拼搏','个性','粗犷','活力','成就','勤劳','单纯','落寞','朴素','悲凉','忧心','洁净','清秀','自由','小巧','单薄','贪玩','刻苦','干净','壮观','和谐','文静','调皮','害羞','安详','自信','端庄','坚定','美满','舒心','温暖','专注','勤恳','美丽','腼腆','优美','甜美','甜蜜','整齐','动人','典雅','尊敬','舒服','妩媚','秀丽','喜悦','甜美','彪壮','强健','大方','俊秀','聪慧','迷人','陶醉','悦耳','动听','明亮','结实','魁梧','标致','清脆','敏感','光亮','大气','老迟到','知性','冷傲','呆萌','野性','隐形','笑点低','微笑','笨笨','难过','沉静','火星上','失眠','安静','纯情','要减肥','迷路','烂漫','哭泣','贤惠','苗条','温婉','发嗲','会撒娇','贪玩','执着','眯眯眼','花痴','想人陪','眼睛大','高贵','傲娇','心灵美','爱撒娇','细腻','天真','怕黑','感性','飘逸','怕孤独','忐忑','高挑','傻傻','冷艳','爱听歌','还单身','怕孤单','懵懂');

            $nicheng_wei=array('嚓茶','凉面','便当','毛豆','花生','可乐','灯泡','哈密瓜','野狼','背包','眼神','缘分','雪碧','人生','牛排','蚂蚁','飞鸟','灰狼','斑马','汉堡','悟空','巨人','绿茶','自行车','保温杯','大碗','墨镜','魔镜','煎饼','月饼','月亮','星星','芝麻','啤酒','玫瑰','大叔','小伙','哈密瓜，数据线','太阳','树叶','芹菜','黄蜂','蜜粉','蜜蜂','信封','西装','外套','裙子','大象','猫咪','母鸡','路灯','蓝天','白云','星月','彩虹','微笑','摩托','板栗','高山','大地','大树','电灯胆','砖头','楼房','水池','鸡翅','蜻蜓','红牛','咖啡','机器猫','枕头','大船','诺言','钢笔','刺猬','天空','飞机','大炮','冬天','洋葱','春天','夏天','秋天','冬日','航空','毛衣','豌豆','黑米','玉米','眼睛','老鼠','白羊','帅哥','美女','季节','鲜花','服饰','裙子','白开水','秀发','大山','火车','汽车','歌曲','舞蹈','老师','导师','方盒','大米','麦片','水杯','水壶','手套','鞋子','自行车','鼠标','手机','电脑','书本','奇迹','身影','香烟','夕阳','台灯','宝贝','未来','皮带','钥匙','心锁','故事','花瓣','滑板','画笔','画板','学姐','店员','电源','饼干','宝马','过客','大白','时光','石头','钻石','河马','犀牛','西牛','绿草','抽屉','柜子','往事','寒风','路人','橘子','耳机','鸵鸟','朋友','苗条','铅笔','钢笔','硬币','热狗','大侠','御姐','萝莉','毛巾','期待','盼望','白昼','黑夜','大门','黑裤','钢铁侠','哑铃','板凳','枫叶','荷花','乌龟','仙人掌','衬衫','大神','草丛','早晨','心情','茉莉','流沙','蜗牛','战斗机','冥王星','猎豹','棒球','篮球','乐曲','电话','网络','世界','中心','鱼','鸡','狗','老虎','鸭子','雨','羽毛','翅膀','外套','火','丝袜','书包','钢笔','冷风','八宝粥','烤鸡','大雁','音响','招牌','胡萝卜','冰棍','帽子','菠萝','蛋挞','香水','泥猴桃','吐司','溪流','黄豆','樱桃','小鸽子','小蝴蝶','爆米花','花卷','小鸭子','小海豚','日记本','小熊猫','小懒猪','小懒虫','荔枝','镜子','曲奇','金针菇','小松鼠','小虾米','酒窝','紫菜','金鱼','柚子','果汁','百褶裙','项链','帆布鞋','火龙果','奇异果','煎蛋','唇彩','小土豆','高跟鞋','戒指','雪糕','睫毛','铃铛','手链','香氛','红酒','月光','酸奶','银耳汤','咖啡豆','小蜜蜂','小蚂蚁','蜡烛','棉花糖','向日葵','水蜜桃','小蝴蝶','小刺猬','小丸子','指甲油','康乃馨','糖豆','薯片','口红','超短裙','乌冬面','冰淇淋','棒棒糖','长颈鹿','豆芽','发箍','发卡','发夹','发带','铃铛','小馒头','小笼包','小甜瓜','冬瓜','香菇','小兔子','含羞草','短靴','睫毛膏','小蘑菇','跳跳糖','小白菜','草莓','柠檬','月饼','百合','纸鹤','小天鹅','云朵','芒果','面包','海燕','小猫咪','龙猫','唇膏','鞋垫','羊','黑猫','白猫','万宝路','金毛','山水','音响');

            $tou_num=rand(0,331);
            $wei_num=rand(0,325);

            $de = mt_rand(0,1);
            if($de){
                $de = '的';
            }else{
                $de = '';
            }

            $has_adv = mt_rand(0,1);
            if($has_adv){
                $nicheng=$nicheng_tou[$tou_num].$de.$nicheng_wei[$wei_num];
            }else{
                $tou = mt_rand(0,1);
                if($tou){
                    $nicheng = $nicheng_tou[$tou_num];
                }else{
                    $nicheng = $nicheng_wei[$wei_num];
                }
            }

        }else{ //英文名
            $faker = \Faker\Factory::create();
            //$nicheng =  $faker->name;
            $nicheng =  $faker->firstName;
            //$faker->firstNameFemale;//女性名
            //firstNameMale //男性名
        }
        return $nicheng; //输出生成的昵称

    }

    /**
     * 计算机用户总共支付金额
     */
    function countUserTotalPayAmount(){
        $sql = "SELECT user_id,SUM(pay_price) as total_pay_amount FROM `order` WHERE `status`=3 GROUP BY user_id";
        $mUser=M('User');
        $r = $mUser->query($sql);

        foreach ($r as $k=>$v){
           $mUser->where(['id'=>$v['user_id']])->save(['total_pay_amount'=>$v['total_pay_amount']]);
           //echo $mUser->getLastSql();
        }


    }

    function downNote(){
        $r = M('Video')->where("note !=''")->select();


        foreach ($r as $v) {
            $url = "http://rrbrr-upload.oss-cn-shanghai.aliyuncs.com/".$v['note'];// '/file/20180121/5a6471f2bb5bb.doc';
            $data = file_get_contents($url);
            $info = pathinfo($v['note']);
            mkdir($info['dirname'],0777,true);
            file_put_contents($v['note'],$data);
        }

    }


    /**
     * 课程系列转
     */
    function videoToCourse($course_id){
        $mCourse = M('Course');
        $rCourse = $mCourse->find($course_id);

        $mCourseVideo = M('CourseVideo');

        $mVideo = M('Video');
        $where['course_id'] = $course_id;
        $r = $mVideo->where($where)->select();
        foreach ($r as $k => $v) {
            $data = [];
            $data['title'] = $v['title'];
            $data['price'] =  0;
            $data['effective_days']=365;
            $data['category_id']=$rCourse['category_id'];
            $data['description'] = $v['title'];
            $data['cover'] = $v['cover'];
            $data['view'] = mt_rand(100,5000);
            $data['user_id'] = $rCourse['user_id'];
            //var_dump($data);exit;
            $id = $mCourse->add($data);


            $data2 = [];
            $data2['course_id'] = $id;
            $data2['video_id'] = $v['id'];
            $mCourseVideo->add($data2);



        }
        //
    }


    function fixVideoInfo(){
        $mVideo = M('Video');
        $r = $mVideo->field('id,video_id')->where(['upload_status'=>3])->select();
        //时长
        $vod = new \Common\Aliyunvod();

        //传到aliyun
        C('UPLOAD_SITEIMG_OSS.savePath','video_cover/');
        $setting=C('UPLOAD_SITEIMG_OSS');
        $upload = new \Think\Upload($setting);

        foreach ($r as $k => $v) {
            $data= [];
            try{
                $info = $vod->getVideoInfo($v['video_id']);
                //var_dump($info);
                if(!empty($info->Duration)) $data['duration'] = $info->Duration;
                if(empty($v['cover'])){
                    //$data['cover'] = $info->CoverURL;
                    /*$temp = tmpfile();
                    $temp = mt_rand(0,10000);*/
                    //echo $info->CoverURL;echo "\n";
                    $img = file_get_contents($info->CoverURL);
                    $size = strlen($img);
                    $tmp_name = "/tmp/"."php".$v['id'].".jpg";
                    file_put_contents($tmp_name,$img);


                    $file = [];
                    $file['savepath'] = "video_cover/";
                    $file['savename'] = uniqid().'.jpg';
                    $file['tmp_name'] = $tmp_name;
                    $file['size'] =$size;
                    $info = $upload->uploader->save($file);

                    $data['cover'] =  $file['savepath'].$file['savename'];
                }
                $mVideo->where(['id'=>$v['id']])->save($data);

                echo $mVideo->getLastSql()."\n";
            }catch (\Exception $e){
                echo($e->getMessage()."\n");
            }
        }

        exit('完成');

    }


    function updateVideoDuration(){
        $mVideo = M('Video');
        $r = $mVideo->field('id,video_id')->select();
        //时长
        $vod = new \Common\Aliyunvod();

        foreach ($r as $k => $v) {
            $data= [];
            try{
                $info = $vod->getVideoInfo($v['video_id']);
                if($info->Status=='Uploading'){


                }elseif($info->Status=='Normal'){
                    $data['upload_status']=3;
                }
                if(!empty($info->Duration)) $data['duration'] = $info->Duration;
                $mVideo->where(['id'=>$v['id']])->save($data);

                echo $mVideo->getLastSql(),LF;
            }catch (\Exception $e){
                echo($e->getMessage()."\n");
            }
        }

    }

	/*
	更新课程试看状态
	*/
    function updateCourseTryPlayStatus(){
        $mVideo = M('Video');
        $mCourse = M('Course');
        $mCourseVideo = M('CourseVideo');
        $r = $mVideo->select();
        foreach ($r as $k => $v) {
            if($v['try_play_length']>0){
                $course_ids = $mCourseVideo->where(['video_id'=>$v['id']])->getField('course_id',true);
                try{
                    $mCourse->where(['id'=>['in',$course_ids]])->setField('try_play',1);
                    echo $mCourse->getLastSql(),LF;
                }catch (\Exception $e){
                    echo "error:",$v['id'],LF;
                }

            }
        }
    }

    function updateVideoSnapshots(){
        $mVideo = M('Video');
        $r = $mVideo->field('id,video_id')->where(['upload_status'=>3])->select();
        //时长
        $vod = new \Common\Aliyunvod();

        foreach ($r as $k => $v) {
            $data= [];
            try{
                $info = $vod->getVideoInfo($v['video_id']);

                if(empty($info->Snapshots)) continue;

                $snapshot=[];
                $data['Snapshots'] = $info->Snapshots;
                foreach ($info->Snapshots->Snapshot as $k2 => $v2){
                    $url = parse_url($v2);
                    $snapshot[] = $url['path'];
                }

                $data['snapshots'] = json_encode($snapshot);
                $mVideo->where(['id'=>$v['id']])->save($data);

                echo $mVideo->getLastSql(),"\n";
            }catch (\Exception $e){
                echo($e->getMessage()."\n");
            }
        }

        exit('完成');

    }

    function gatherYouku(){
        $thirdparty = new \Common\ThirdpartyVideo();
        for ($i = 2; $i<=6; $i++){
            //$i = 0;

            //url格式1
            $url = "http://list.youku.com/show/point?id=305578&stage=reload_{$i}1&callback=jQuery1112008556277043872895_1513709799135&_=1513709799149";
            $reg = '#<a href="//v.youku.com/v_show/id_(.*?).html" title="(.*?)" .*?<img class="" src="(.*?)" .*?<span class="p-time"><i class="ibg"></i><span>(.*?)</span>#';

            //url 格式2
            $url = "http://list.youku.com/albumlist/items?id=961528&page={$i}&size=20&ascending=1&callback=tuijsonp8";
            $reg = '#<a href="//v.youku.com/v_show/id_(.*?).html.*?" title="(.*?)" .*?<img .*? src="(.*?)" .*?<i class="ibg"></i><span>(.*?)</span>#';



            $r = file_get_contents($url);
            $start = strpos($r,'{');
            $r = substr($r,$start,-2);
            $r = json_decode($r,1);
            $html = $r['html'];
            //var_dump($html);exit;

            $url_prefix = 'http://v.youku.com/v_show/id_';
            preg_match_all($reg,$html,$out);

            $count = count($out[0]);
            //$count = 1;



            for($j = 0; $j<$count; $j++){
                $videoInfo = [];
                $videoInfo['url'] = $url_prefix.$out[1][$j];
                $videoInfo['title'] = $out[2][$j];
                $videoInfo['thumb'] = $out[3][$j];
                $videoInfo['duration'] = $out[4][$j];
                //echo $url,LF;
                var_dump($videoInfo);
                echo '===================================',"\n";

                //入库
                // $this->addLinkCourse($thirdparty,$videoInfo,'youku','961528');
            }

        }

        //var_dump($out);

    }

    function gatherTudou(){
        for ($i = 1; $i<=10; $i++){
            $url = 'http://www.soku.com/nt/search/q_%E4%BB%8A%E6%97%A5%E8%AF%B4%E6%B3%95_orderby_1_limitdate_0?spm=a2h0k.8191414.0.0&site=14&page='.$i;
            $reg = '/<div class=\"v\" data-type=\"tipHandle\">.*?<\/i>/ism';
            $r = file_get_contents($url);
            preg_match_all($reg,$r,$out);
            $reg_title = '/<img alt=\"(.*?)\"/ism';
            $reg_img = '/src=\"\/\/(.*?)\">/ism';
            $reg_time = '/<span class=\"v-time\">(.*?)<\/span>/ism';
            $reg_url = '/href=\"\/\/(.*?)\"/ism';
            foreach ($out[0] as $key=>$item) {
                // dump($item);exit;
                preg_match_all($reg_title,$item,$title);
                preg_match_all($reg_img,$item,$img);
                preg_match_all($reg_time,$item,$time);
                preg_match_all($reg_url,$item,$url);
                // dump($url);exit;
                $videoInfo[$key]['title'] = $title[1][0];
                $videoInfo[$key]['img'] = $img[1][0];
                $videoInfo[$key]['time'] = $time[1][0];
                $videoInfo[$key]['url'] = $url[1][0];
            }
            var_dump($videoInfo);exit;
        }
    }

    function gather56(){
        for ($i = 1; $i<=10; $i++){
            $url = 'http://so.56.com/mts?wd=%E8%B5%B7%E5%B0%8F%E7%82%B9top10&c=0&v=0&length=0&limit=0&site=0&o=0&p='.$i.'&st=&suged=&filter=0';
            echo $url;
            $r = file_get_contents($url);
            $reg = '/<div class=\"pic170\" >.*?<\/div>/ism';
            preg_match_all($reg,$r,$out);
            $reg_title = '/title=\"(.*?)\"/ism';
            $reg_img = '/src=\"\/\/(.*?)\"/ism';
            $reg_time = '/<span class=\"maskTx\">(.*?)<\/span>/ism';
            $reg_url = '/href=\"\/\/(.*?)\"/ism';
            foreach ($out[0] as $key=>$item) {
                // dump($item);exit;
                preg_match_all($reg_title,$item,$title);
                preg_match_all($reg_img,$item,$img);
                preg_match_all($reg_time,$item,$time);
                preg_match_all($reg_url,$item,$url);
                // dump($url);exit;
                $videoInfo[$key]['title'] = $title[1][0];
                $videoInfo[$key]['img'] = $img[1][0];
                $videoInfo[$key]['time'] = $time[1][0];
                $videoInfo[$key]['url'] = $url[1][0];
            }
            var_dump($videoInfo);exit;
        }
    }

    function gatherIqy(){
        for ($i = 1; $i<=10; $i++){
            $url = 'http://so.iqiyi.com/so/q_%E4%BB%8A%E6%97%A5%E8%AF%B4%E6%B3%95_ctg__t_0_page_'.$i.'_p_1_qc_0_rd__site__m_1_bitrate_';
            $r = file_get_contents($url);
            $reg = '/<a class=\"figure  figure-180101 \".*?<\/a>/ism';
            preg_match_all($reg,$r,$out);
            // dump($out);exit;
            $reg_title = '/title=\"(.*?)\"/ism';
            $reg_img = '/src=\"http\:\/\/(.*?)\"/ism';
            $reg_time = '/<span class=\"icon-vInfo\">(.*?)<\/span>/ism';
            $reg_url = '/href=\"http\:\/\/(.*?)\"/ism';
            foreach ($out[0] as $key=>$item) {
                // dump($item);exit;
                preg_match_all($reg_title,$item,$title);
                preg_match_all($reg_img,$item,$img);
                preg_match_all($reg_time,$item,$time);
                preg_match_all($reg_url,$item,$url);
                // dump($url);exit;
                $videoInfo[$key]['title'] = $title[1][0];
                $videoInfo[$key]['img'] = $img[1][0];
                $videoInfo[$key]['time'] = $time[1][0];
                $videoInfo[$key]['url'] = $url[1][0];
            }
            var_dump($videoInfo);exit;
        }
    }

    function gatherQq(){
        for ($i = 1; $i<=10; $i++){
            $url = 'https://v.qq.com/x/search/?ses=qid%3DG_f96n9o_bloRAvexTPhp5zseeacqCr_0E95mCJtfJLcslDA15zJpQ%26last_query%3D%E4%BB%8A%E6%97%A5%E8%AF%B4%E6%B3%95%26tabid_list%3D0%7C11%7C7%7C2%7C3%7C6%7C12%7C14%7C17%7C15%26tabname_list%3D%E5%85%A8%E9%83%A8%7C%E6%96%B0%E9%97%BB%7C%E5%85%B6%E4%BB%96%7C%E7%94%B5%E8%A7%86%E5%89%A7%7C%E7%BB%BC%E8%89%BA%7C%E7%BA%AA%E5%BD%95%E7%89%87%7C%E5%A8%B1%E4%B9%90%7C%E4%BD%93%E8%82%B2%7C%E6%B8%B8%E6%88%8F%7C%E6%95%99%E8%82%B2&q=%E4%BB%8A%E6%97%A5%E8%AF%B4%E6%B3%95&stag=3&cur='.$i.'&cxt=tabid%3D0%26sort%3D0%26pubfilter%3D0%26duration%3D0';
            $r = file_get_contents($url);var_dump($r);exit;
            $reg = '/<a class=\"figure  figure-180101 \".*?<\/a>/ism';
            preg_match_all($reg,$r,$out);

            $reg_title = '/title=\"(.*?)\"/ism';
            $reg_img = '/src=\"http\:\/\/(.*?)\"/ism';
            $reg_time = '/<span class=\"icon-vInfo\">(.*?)<\/span>/ism';
            $reg_url = '/href=\"http\:\/\/(.*?)\"/ism';
            foreach ($out[0] as $key=>$item) {
                // dump($item);exit;
                preg_match_all($reg_title,$item,$title);
                preg_match_all($reg_img,$item,$img);
                preg_match_all($reg_time,$item,$time);
                preg_match_all($reg_url,$item,$url);
                // dump($url);exit;
                $videoInfo[$key]['title'] = $title[1][0];
                $videoInfo[$key]['img'] = $img[1][0];
                $videoInfo[$key]['time'] = $time[1][0];
                $videoInfo[$key]['url'] = $url[1][0];
            }
            dump($videoInfo);exit;
        }
    }

    function copyVideo(){
        $mVideo = M('video');
        $mCourseVideo = M('courseVideo');
        $r = M('courseVideo')->where(['course_id'=>12957])->select();
        foreach ($r as $k => $v) {
            $d = [];
            $video_id = $v['video_id'];
            $rVideo = $mVideo->find($video_id);
            $d = [];
            $d = $rVideo;
            unset($d['id']);
            $d['course_id'] = 12957;
            $newVideoId = $mVideo->add($d);
            echo $mVideo->getLastSql(),"\n";

            $mCourseVideo->where(['id'=>$v['id']])->save(['video_id'=>$newVideoId]);

            echo $mCourseVideo->getLastSql(),"\n\n";

        }

    }

  function copyVideo(){
        $mVideo = M('video');
        $mCourseVideo = M('courseVideo');
        $r = M('courseVideo')->where(['course_id'=>12957])->select();
        foreach ($r as $k => $v) {
            $d = [];
            $video_id = $v['video_id'];
            $rVideo = $mVideo->find($video_id);
            $d = [];
            $d = $rVideo;
            unset($d['id']);
            $d['course_id'] = 12957;
            $newVideoId = $mVideo->add($d);
            echo $mVideo->getLastSql(),"\n";

            $mCourseVideo->where(['id'=>$v['id']])->save(['video_id'=>$newVideoId]);

            echo $mCourseVideo->getLastSql(),"\n\n";

        }

    }

    function export(){
        set_time_limit(0);
        $m = M('Test','',C('test_db'));
            $sql = "SHOW TABLES WHERE Tables_in_$dbname not  LIKE '%0%';";
            $ret =$m->query($sql);
            while($row = mysqli_fetch_assoc($ret)){
                $info1[] = $row["Tables_in_$dbname"];
            }
            foreach ($info1 as $val) {
                $cmd = "mysqldump --default-character-set=utf8 -u pm_user1 -h 127.0.0.1  -pGzEZ2+FJa` $dbname $val --where='1 limit 100'   >> $val.sql";
                shell_exec($cmd);
            }
    }

}
