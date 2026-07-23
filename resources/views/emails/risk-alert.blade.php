<!DOCTYPE html>
<html>
<head>
    <title>Alerta - Sistema de Gestão de Riscos</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; border-top: 4px solid #ef4444;">
        <h2 style="color: #1f2937; margin-top: 0;">{{ $alertSubject }}</h2>
        
        <p style="font-size: 16px;">Olá,</p>
        
        <p style="font-size: 16px; background-color: #fff; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0;">
            {{ $alertMessage }}
        </p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $actionUrl }}" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">
                Aceder ao Sistema
            </a>
        </div>
        
        <p style="font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 15px; margin-bottom: 0;">
            Este é um e-mail automático do Sistema de Gestão de Riscos corporativo. Por favor, não responda.
        </p>
    </div>

</body>
</html>
