<?php
class DashboardController extends Controller {
    private function ensure(){
        if(empty($_SESSION['user'])) redirect('?r=auth/login');
    }
    
    private function getTodaysSummary() {
        $db = Database::getInstance()->getConnection();
        $today = date('Y-m-d');
        
        // Today's expenses
        $stmt = $db->prepare("SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE DATE(expense_date) = :today");
        $stmt->execute(['today' => $today]);
        $todayExpenses = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Today's purchases
        $stmt = $db->prepare("SELECT COALESCE(SUM(quantity * unit_price), 0) as total FROM purchases WHERE DATE(purchase_date) = :today");
        $stmt->execute(['today' => $today]);
        $todayPurchases = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Today's credit sales
        $stmt = $db->prepare("SELECT COALESCE(SUM(total_price), 0) as total FROM credit_sales WHERE DATE(created_at) = :today");
        $stmt->execute(['today' => $today]);
        $todayCreditSales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Count of credit sales today
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM credit_sales WHERE DATE(created_at) = :today");
        $stmt->execute(['today' => $today]);
        $todayCreditCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Total clients
        $stmt = $db->query("SELECT COUNT(*) as count FROM clients");
        $totalClients = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Active (pending) credits
        $stmt = $db->query("SELECT COUNT(*) as count FROM credit_sales WHERE status = 'pending'");
        $activeCredits = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        return [
            'todayExpenses' => $todayExpenses,
            'todayPurchases' => $todayPurchases,
            'todayCreditSales' => $todayCreditSales,
            'todayCreditCount' => $todayCreditCount,
            'totalClients' => $totalClients,
            'activeCredits' => $activeCredits
        ];
    }
    
    private function getTrendData($days = 7) {
        $db = Database::getInstance()->getConnection();
        $trendData = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dayName = date('D', strtotime($date)); // Mon, Tue, etc.
            
            // Credit Sales for this day
            $stmt = $db->prepare("SELECT COALESCE(SUM(total_price), 0) as total FROM credit_sales WHERE DATE(created_at) = :date");
            $stmt->execute(['date' => $date]);
            $salesTotal = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Purchases for this day
            $stmt = $db->prepare("SELECT COALESCE(SUM(quantity * unit_price), 0) as total FROM purchases WHERE DATE(purchase_date) = :date");
            $stmt->execute(['date' => $date]);
            $purchasesTotal = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $trendData[] = [
                'date' => $date,
                'day' => $dayName,
                'sales' => $salesTotal,
                'purchases' => $purchasesTotal
            ];
        }
        
        return $trendData;
    }
    
    public function index(){
        $this->ensure();
        $user = $_SESSION['user'];
        if($user['role']==='manager'){
            $creditModel = $this->model('Credit');
            $creditModel->updateOverdueStatuses();
            $overdue = $creditModel->overdue();
            // Notification logic
            $notified = $_SESSION['overdue_notified'] ?? 0;
            $newOverdueCount = count($overdue);
            $showOverdueAlert = false;
            if ($newOverdueCount > 0 && $newOverdueCount !== $notified) {
                $showOverdueAlert = true;
                $_SESSION['overdue_notified'] = $newOverdueCount;
                // Send email if not sent for this count
                require_once __DIR__ . '/../core/mail.php';
                // Always fetch manager email from DB for accuracy
                $userModel = $this->model('User');
                $manager = $userModel->findById($user['user_id']);
                // Multiple recipients support
                $recipients = [];
                if (!empty($manager['email'])) $recipients[] = $manager['email'];
                // Add more recipients as needed:
                $recipients[] = 'another.manager@example.com'; // Example additional recipient
                $recipients[] = 'owner@example.com'; // Another sample recipient
                if (empty($recipients)) $recipients[] = 'admin@example.com';

                $subject = 'Overdue Credit Notification';
                $body = '<h3>Overdue Credits Alert</h3>';
                $body .= '<p>There are ' . $newOverdueCount . ' overdue credits in the system.</p>';
                $body .= '<ul>';
                foreach($overdue as $cr) {
                    $body .= '<li>Client: ' . htmlspecialchars($cr['client_name']) . ' | Phone: ' . htmlspecialchars($cr['phone']) . ' | Due: ' . htmlspecialchars($cr['due_date']) . ' | Amount: ' . number_format($cr['total_price'],2) . '</li>';
                }
                $body .= '</ul>';
                // Only allow real/major email providers and valid format
                $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com'];
                foreach ($recipients as $to) {
                    $to = trim($to);
                    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) continue;
                    $domain = strtolower(substr(strrchr($to, '@'), 1));
                    if (!in_array($domain, $allowedDomains)) continue;
                    sendMail($to, $subject, $body);
                }
            }
            $summary = $this->getTodaysSummary();
            $trendData = $this->getTrendData(7);
            $this->view('dashboard/manager',[
                'overdue'=>$overdue, 
                'showOverdueAlert'=>$showOverdueAlert, 
                'overdueCount'=>$newOverdueCount,
                'summary' => $summary,
                'trendData' => $trendData
            ]);
        } else {
            $summary = $this->getTodaysSummary();
            $trendData = $this->getTrendData(7);
            $this->view('dashboard/staff', ['summary' => $summary, 'trendData' => $trendData]);
        }
    }
}
