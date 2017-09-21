<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class frmfilter
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.pnl_message_arr = New System.Windows.Forms.Panel()
        Me.ChromeButton12 = New MergeSMS_ver_3._0.ChromeButton()
        Me.SuspendLayout()
        '
        'pnl_message_arr
        '
        Me.pnl_message_arr.AutoScroll = True
        Me.pnl_message_arr.BackColor = System.Drawing.Color.White
        Me.pnl_message_arr.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.pnl_message_arr.Location = New System.Drawing.Point(7, 15)
        Me.pnl_message_arr.Name = "pnl_message_arr"
        Me.pnl_message_arr.Size = New System.Drawing.Size(562, 433)
        Me.pnl_message_arr.TabIndex = 29
        '
        'ChromeButton12
        '
        Me.ChromeButton12.Customization = "7e3t//Ly8v/r6+v/4ODg/+vr6//AwMD/p6en/zw8PP8UFBT/gICA/w=="
        Me.ChromeButton12.Font = New System.Drawing.Font("Segoe UI", 9.0!)
        Me.ChromeButton12.Image = Nothing
        Me.ChromeButton12.Location = New System.Drawing.Point(7, 459)
        Me.ChromeButton12.Name = "ChromeButton12"
        Me.ChromeButton12.NoRounding = False
        Me.ChromeButton12.Size = New System.Drawing.Size(562, 29)
        Me.ChromeButton12.TabIndex = 28
        Me.ChromeButton12.Text = "Save"
        Me.ChromeButton12.Transparent = False
        '
        'frmfilter
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(7.0!, 15.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(576, 499)
        Me.Controls.Add(Me.pnl_message_arr)
        Me.Controls.Add(Me.ChromeButton12)
        Me.Font = New System.Drawing.Font("Segoe UI", 9.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog
        Me.MaximizeBox = False
        Me.MinimizeBox = False
        Me.Name = "frmfilter"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent
        Me.Text = "SMS Filter form"
        Me.TransparencyKey = System.Drawing.Color.Fuchsia
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents pnl_message_arr As System.Windows.Forms.Panel
    Friend WithEvents ChromeButton12 As MergeSMS_ver_3._0.ChromeButton
End Class
