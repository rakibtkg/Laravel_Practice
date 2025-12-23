<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Admit Card</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 18px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        .row {
            display: flex;
            gap: 20px;
        }
        .col {
            flex: 1;
        }
        .subject-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .subject-section h3 {
            margin-bottom: 15px;
            color: #333;
        }
        .subject-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .bill-section {
            margin-top: 20px;
            padding: 20px;
            background: #fff3cd;
            border-radius: 5px;
        }
        .bill-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            margin-bottom: 5px;
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Undergraduate Admission</h1>
        <p class="subtitle">Acknowledgement Slip Generator</p>

        <form action="{{ route('admit.generate') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Unit <span class="required">*</span></label>
                <select name="unit" required>
                    <option value="">Select Unit</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <div class="form-group">
                <label>GST Roll <span class="required">*</span></label>
                <input type="text" name="gst_roll" placeholder="e.g., 100002" required>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Candidate Name <span class="required">*</span></label>
                        <input type="text" name="candidate_name" placeholder="Full Name" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Photo <span class="required">*</span></label>
                        <input type="file" name="photo" accept="image/*" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Father's Name <span class="required">*</span></label>
                        <input type="text" name="father_name" placeholder="Father's Full Name" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Mother's Name <span class="required">*</span></label>
                        <input type="text" name="mother_name" placeholder="Mother's Full Name" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Quota <span class="required">*</span></label>
                <select name="quota" required>
                    <option value="">Select Quota</option>
                    <option value="FFQ-GC">FFQ-GC (Freedom Fighter Quota - Grand Children)</option>
                    <option value="FFQ">FFQ (Freedom Fighter Quota)</option>
                    <option value="General">General</option>
                    <option value="Tribal">Tribal</option>
                </select>
            </div>

            <div class="bill-section">
                <h3>Bill Information</h3>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Pending Bill No</label>
                            <input type="text" name="pending_bill_no" placeholder="e.g., 1000023">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Pending Amount</label>
                            <input type="number" name="pending_amount" placeholder="e.g., 500">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Paid Bill No</label>
                            <input type="text" name="paid_bill_no" placeholder="e.g., 1000022">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Paid Amount</label>
                            <input type="number" name="paid_amount" placeholder="e.g., 1000">
                        </div>
                    </div>
                </div>
            </div>

            <div class="subject-section">
                <h3>Subject Choice Order</h3>
                <div class="subject-item">
                    <label>Mathematics</label>
                    <input type="number" name="subjects[Mathematics]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
                <div class="subject-item">
                    <label>Management</label>
                    <input type="number" name="subjects[Management]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
                <div class="subject-item">
                    <label>Social Work</label>
                    <input type="number" name="subjects[Social Work]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
                <div class="subject-item">
                    <label>Fisheries</label>
                    <input type="number" name="subjects[Fisheries]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
                <div class="subject-item">
                    <label>Computer Science and Engineering</label>
                    <input type="number" name="subjects[Computer Science and Engineering]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
                <div class="subject-item">
                    <label>Electrical and Electronics Engineering</label>
                    <input type="number" name="subjects[Electrical and Electronics Engineering]" min="1" max="6" placeholder="Choice" style="width: 100px;">
                </div>
            </div>

            <button type="submit" class="btn">Generate Admit Card PDF</button>
        </form>
    </div>
</body>
</html>
