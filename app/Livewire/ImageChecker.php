<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Client\RequestException;

class ImageChecker extends Component
{
    use WithFileUploads;

    // Свойство для связывания с input[type=file]
    public $image;

    // Свойства для отображения результата
    public $message = '';
    public $apiErrors = null;
    public $isError = false;
    public $initialCooldown = 0;
    private $cooldownDuration = 10;
    public $imageSubmitted = false;

    /**
     * Правила валидации для Livewire.
     */
    protected function rules()
    {
        return [
            'image' => 'required|image|max:5120', // 5MB
        ];
    }

    public function mount()
    {
        $cooldownExpiresAt = session('cooldown_expires_at');
        if ($cooldownExpiresAt && now()->lt($cooldownExpiresAt)) {
            $this->initialCooldown = (int) round(now()->diffInSeconds($cooldownExpiresAt));
        }
    }

    /**
     * Сообщения для валидации.
     */
    protected function messages()
    {
        return [
            'image.required' => __('site.select_image'),
            'image.image' => 'Файл должен быть изображением.',
            'image.max' => 'Изображение не должно превышать 5MB.',
        ];
    }

    /**
     * Этот метод (lifecycle hook) вызывается каждый раз,
     * когда свойство $image обновляется (т.е. пользователь выбрал файл).
     */
    public function updatedImage()
    {
        // Сбрасываем старые сообщения об ошибках
        $this->resetErrorBag();
        $this->reset('message', 'isError', 'apiErrors', 'imageSubmitted');

        // Запускаем валидацию в реальном времени
        $this->validateOnly('image');
    }

    /**
     * Основной метод, который будет вызван при отправке формы.
     */
    public function save()
{
    $cooldownExpiresAt = session('cooldown_expires_at');
        if ($cooldownExpiresAt && now()->lt($cooldownExpiresAt)) {
            return;
        }

    $this->validate();

    $this->reset('message', 'isError', 'apiErrors');

    $locale = app()->getLocale()==='kk' ? 'kz' : 'ru';

    try {
        $imagePath = $this->image->getRealPath();
        $base64 = base64_encode(file_get_contents($imagePath));

        $response = Http::withBody(
            json_encode($base64),
            'application/json'
        )->post('https://10.25.1.180:5050/Photo/PhotoValidate?lang='.$locale);

        $statusCode = $response->status();
        $body = trim($response->body());
        
        if (!$response->successful()) {
            $this->isError = true;
            $this->message = "Ошибка при обращении к сервису. Код ответа: {$statusCode}. Ответ: {$body}";
            return; // Выходим из функции
        }

        // --- Блок для успешных ответов (2xx) ---
        
        if ($this->isJson($body)) {
            $json = json_decode($body, true);

            if (isset($json['isValid']) && $json['isValid'] === false) {
                $this->isError = true; // Это логическая ошибка!
                if (!empty($json['errors']) && is_array($json['errors'])) {
                    $this->apiErrors = $json['errors'];
                } else {
                    $this->apiErrors = null;
                }
                
            } else {
                $this->isError = false;
                $this->message = $json['message'] ?? __('site.image_success');
                $this->apiErrors = null;
            }
            
        } else {
            $this->isError = false;
            $this->message = $body ?: 'Пустой успешный ответ от сервиса.';
        }

    } catch (RequestException $e) {
        $this->isError = true;
        $this->message = __('message.network_error');
    } catch (\Throwable $e) {
        $this->isError = true;
        $this->message = __('message.unexpected_error').': ' . $e->getMessage();
    }
     finally {
            $this->imageSubmitted = true;
            session(['cooldown_expires_at' => now()->addSeconds($this->cooldownDuration)]);
            $this->dispatch('start-cooldown', seconds: $this->cooldownDuration);
        }
}

    /**
     * Вспомогательная функция для проверки, является ли строка JSON.
     */
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function render()
    {
        return view('livewire.image-checker');
    }
}
