<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json([
                'reply' => 'Vui lòng nhập nội dung để tôi có thể trả lời nhé 🥰'
            ]);
        }

        try {
            // 🔹 Gửi yêu cầu tới Hugging Face API
            $endpoint = 'https://api-inference.huggingface.co/models/HuggingFaceH4/zephyr-7b-beta';

            \Log::info('🧩 HuggingFace API called', ['message' => $userMessage]);
            \Log::info('🔗 Endpoint', ['url' => $endpoint]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post($endpoint, [
                'inputs' => "Người dùng hỏi: {$userMessage}\nHãy trả lời ngắn gọn, thân thiện, lịch sự như nhân viên tư vấn bán hàng HS Store.",
                'parameters' => [
                    'max_new_tokens' => 200,
                    'temperature' => 0.7
                ],
                'options' => [
                    'wait_for_model' => true
                ],
            ]);

            \Log::info('🔍 HTTP Status', ['status' => $response->status()]);
            \Log::info('📦 Raw Body', ['body' => $response->body()]);

            $data = $response->json();

            // 🧠 Ghi log phản hồi API
            \Log::info('🧠 Response', ['data' => $data]);

            // 🔍 Lấy nội dung trả về
            if (isset($data[0]['generated_text'])) {
                $reply = trim($data[0]['generated_text']);
            } elseif (isset($data['error'])) {
                $reply = '⚠️ Lỗi API: ' . $data['error'];
            } else {
                $reply = 'Xin lỗi, tôi chưa hiểu câu hỏi 😅';
            }

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            // 🚨 Ghi lại lỗi chi tiết để debug
            \Log::error('❌ Lỗi khi kết nối Hugging Face', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'reply' => 'Lỗi khi kết nối tới AI: ' . $e->getMessage()
            ]);
        }
    }
}
