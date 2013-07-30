<?php
/**
 * File: SendCloud.php
 * User: xiahao
 * Date: 13-4-8
 * Time: 下午5:27
 * Email: do.not.reply@foxmail.com
 */
class ESendCloud extends CApplicationComponent
{
    private $_sendCloud;
    public $sendCloudPathAlias = 'site.common.lib.sendcloud';
    public $sendCloudUsername;
    public $sendCloudPassword;
	public $debug = false;

    public $sendFromAddress = '';
    public $sendFromName = '';
    public $timeLimit = 30;


    public function init()
    {
        $path = Yii::getPathOfAlias($this->sendCloudPathAlias);
        require_once $path . '/lib/phpmailer/class.phpmailer.php';
        require_once $path . '/lib/phpmailer/class.smtp.php';
        require_once $path . '/lib/phpmailer/language/phpmailer.lang-zh_cn.php';
        require_once $path . '/SendCloud.php';
        require_once $path . '/SendCloud/Smtp.php';
        require_once $path . '/SendCloud/Message.php';
        require_once $path . '/SendCloud/AppFilter.php';
        require_once $path . '/SendCloud/SmtpApiHeader.php';
        if (!($this->_sendCloud instanceof SendCloud)) {
            $this->_sendCloud = new SendCloud($this->sendCloudUsername, $this->sendCloudPassword);
            $this->_sendCloud->setDebug($this->debug);
        }
        return parent::init();
    }

    /**
     * 发送邮件
     * 用于执行发送邮件
     * @param $sendTo   收件人邮件地址  字符串或数组
     * @param $subject  邮件主题
     * @param $content  邮件正文
     * @param array|stirng $attachmentFiles    附件路径，多个附件时 该值为数组
     */
    public function send($sendTo, $subject, $content, $attachmentFiles = array()){
        try {
            // 设置脚本执行的最长时间，以免附件较大时，需要传输比较久的时间
            @set_time_limit($this->timeLimit);

            if(is_string($sendTo)){
                $sendTo = array($sendTo);
            }
            $message = new SendCloud\Message();
            $message->addRecipients($sendTo) // 添加批量接受地址
                ->setReplyTo('mail@zhuijumi.com') // 添加回复地址
                ->setFromName('追剧迷') // 添加发送者称呼
                ->setFromAddress('service@zhuijumi.com') // 添加发送者地址
                ->setSubject($subject)  // 邮件主题
                ->setBody($content);// 邮件正文纯文本形式，这个不是必须的。

            // 二进制或者字符串流附件
            // $data = file_get_contents(iconv('UTF-8', 'GBK', 'E:\path\SendCloud使用指南.pdf'));
            //$message->addStringAttachment($data, 'SendCloud使用指南.pdf');
            // 普通附件
            //$message->addAttachment('E:\path\SendCloud测试.xls')
            //    ->addAttachment('E:\path\SendCloud测试.pdf', 'SendCloud测试--重命名.pdf');

            //添加附件
            if(!empty($attachmentFiles)){
                $attachmentFiles = is_string($attachmentFiles) ? array($attachmentFiles) : $attachmentFiles;
                foreach($attachmentFiles as $file){
                    if(is_file($file)){
                        $message->addAttachment($file);
                    }
                }
            }

            return $this->_sendCloud->send($message);
            //print '<br>emailIdList:';
            //print var_dump($this->_sendCloud->getEmailIdList());// 取得emailId列表
        } catch (Exception $e) {
            //print "出现错误:";
            print $e->getMessage();
        }
    }
}
