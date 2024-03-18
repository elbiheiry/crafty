<?php

namespace App\Traits;
use Aws\Exception\AwsException;
use Aws\MediaConvert\MediaConvertClient;

trait UploadVideo 
{
    public function upload_video($video , $video_link , $column)
    {
        $mediaConvertClient = new MediaConvertClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            // 'profile' => 'default',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'endpoint' => 'https://q25wbt2lc.mediaconvert.us-east-1.amazonaws.com'
        ]);
        $settings = [
            "TimecodeConfig" => [
                "Source" => "ZEROBASED"
            ],
            "OutputGroups" => [
                [
                    "Name" => "Apple HLS",
                    "Outputs" => [
                        [
                            "Preset" => "System-Avc_16x9_1080p_29_97fps_8500kbps",
                            "NameModifier" => "test/1080"
                        ],
                        [
                            "Preset" => "System-Avc_16x9_720p_29_97fps_6500kbps",
                            "NameModifier"=> "test/720"
                        ],
                        [
                            "Preset"=> "System-Avc_4x3_480p_29_97fps_600kbps",
                            "NameModifier"=> "test/480"
                        ],
                        [
                            "Preset"=> "System-Avc_16x9_360p_29_97fps_1200kbps",
                            "NameModifier"=> "test/360"
                        ],
                        [
                            "Preset"=> "System-Avc_16x9_270p_14_99fps_400kbps",
                            "NameModifier"=> "test/270"
                        ]
                    ],
                    "OutputGroupSettings" => [
                        "Type" => "HLS_GROUP_SETTINGS",
                        "HlsGroupSettings"=> [
                            "SegmentLength" => 10,
                            "Destination" => "s3://crafty-videos/outputs/",
                            "MinSegmentLength" => 0
                        ]
                    ]
                ]
            ],
            "Inputs" => [
                [
                    "AudioSelectors" => [
                        "Audio Selector 1" => [
                            "DefaultSelection" => "DEFAULT"
                        ]
                    ],
                    "VideoSelector" => [],
                    "TimecodeSource" => "ZEROBASED",
                    "FileInput" => "s3://crafty-videos/videos/".$video_link
                ]
            ]
        ];

        // MediaConvert::createJob($settings, $metaData = [] ,$tags = [], $priority = 0);
        try {
            $result = $mediaConvertClient->createJob([
                "Role" => "arn:aws:iam::033536802495:role/service-role/MediaConvert_Default_Role",
                "Settings" => $settings, //JobSettings structure
                "Queue" => "arn:aws:mediaconvert:us-east-1:033536802495:queues/Default",
                "UserMetadata" => [
                    "Customer" => "Amazon"
                ],
            ]);
            $video->update([
                $column => $result['Job']['Id']
            ]);
        } catch (AwsException $e) {
            // output error message if fails
            dd($e->getMessage());
        }
    }
}