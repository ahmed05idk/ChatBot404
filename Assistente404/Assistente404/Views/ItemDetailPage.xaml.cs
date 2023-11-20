using Assistente404.ViewModels;
using System.ComponentModel;
using Xamarin.Forms;

namespace Assistente404.Views
{
    public partial class ItemDetailPage : ContentPage
    {
        public ItemDetailPage()
        {
            InitializeComponent();
            BindingContext = new ItemDetailViewModel();
        }
    }
}